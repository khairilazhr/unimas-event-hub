<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Event;
use App\Models\EventRegistration;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class OrganizerController extends Controller
{
    public function dashboard()
    {
        // Get the currently logged-in user
        $user = Auth::user();

        // Retrieve events for the current organizer with status and registration count
        $events = Event::where('organizer_id', $user->id)
            ->withCount('registrations') // count from EventRegistration where event_id = event.id
            ->orderBy('date', 'asc')
            ->get();

        // Total stats
        $totalParticipants = $events->sum('registrations_count');
        $totalEvents = $events->count();
        $upcomingEvents = $events->where('status', 'upcoming')->count();

        // Placeholder logic
        $pendingPayments = 0;

        return view('organizer.organizer-dashboard', [
            'events' => $events,
            'totalEvents' => $totalEvents,
            'upcomingEvents' => $upcomingEvents,
            'pendingPayments' => $pendingPayments,
            'totalParticipants' => $totalParticipants,
        ]);
    }

    public function index()
    {
        $events = Event::withCount('registrations')->get(); // Eager load with total count

        return response()->json($events);
    }

    public function show($id)
    {
        $event = Event::with('registrations')->withCount('registrations')->findOrFail($id);

        return response()->json($event);
    }

    public function myEvents()
    {
        $user = Auth::user();
        $events = Event::where('organizer_id', $user->id)->get();

        return view('organizer.events.my-events', compact('events'));
    }

    public function createEvent()
    {
        return view('organizer.events.create-event');
    }

    public function storeEvent(Request $request)
    {
        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => 'required|date',
            'location' => 'required|string|max:255',
            'organizer_name' => 'required|string|max:255',
            'poster' => 'nullable|image|max:2048',
            'qr_code' => 'nullable|image|max:2048',
            'payment_details' => 'nullable|string|max:1000',
            'supporting_docs' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'refund_type' => 'nullable|string|max:255',
            'refund_policy' => 'nullable|string|max:1000',
            'tickets' => 'required|array|min:1',
            'tickets.*.section' => 'required|string|max:255',
            'tickets.*.type' => 'required|string|max:255',
            'tickets.*.price' => 'required|numeric|min:0',
            'tickets.*.description' => 'nullable|string',
            'tickets.*.rows' => 'required|integer|min:1',
            'tickets.*.seats_per_row' => 'required|integer|min:1',
        ]);

        $posterPath = null;
        if ($request->hasFile('poster') && $request->file('poster')->isValid()) {
            $posterPath = $request->file('poster')->store('posters', 'public');
        }

        $qrcodePath = null;
        if ($request->hasFile('qr_code') && $request->file('qr_code')->isValid()) {
            $qrcodePath = $request->file('qr_code')->store('qr_codes', 'public');
        }

        $supportingDocsPath = null;
        if ($request->hasFile('supporting_docs') && $request->file('supporting_docs')->isValid()) {
            $supportingDocsPath = $request->file('supporting_docs')->store('supporting_docs', 'public');
        }

        $event = new Event;
        $event->name = $request->input('name');
        $event->description = $request->input('description');
        $event->date = $request->input('date');
        $event->location = $request->input('location');
        $event->organizer_name = $request->input('organizer_name');
        $event->poster = $posterPath;
        $event->qr_code = $qrcodePath;
        $event->payment_details = $request->input('payment_details');
        $event->supporting_docs = $supportingDocsPath;
        $event->refund_type = $request->input('refund_type');
        $event->refund_policy = $request->input('refund_policy');
        $event->organizer_id = Auth::id();
        $event->status = 'pending';
        $event->save();

        // Process ticket sections
        if ($request->has('tickets')) {
            foreach ($request->tickets as $ticketData) {
                // Create ticket types based on rows and seats per row
                $rows = $ticketData['rows'];
                $seatsPerRow = $ticketData['seats_per_row'];

                for ($row = 1; $row <= $rows; $row++) {
                    for ($seat = 1; $seat <= $seatsPerRow; $seat++) {
                        $ticket = new Ticket;
                        $ticket->eventId = $event->id; // Link ticket to event
                        $ticket->type = $ticketData['type'];
                        $ticket->price = $ticketData['price'];
                        $ticket->description = $ticketData['description'] ?? null;
                        $ticket->section = $ticketData['section'];
                        $ticket->row = $row;
                        $ticket->seat = $seat;
                        $ticket->save();
                    }
                }
            }
        }

        return redirect()->route('organizer.events')->with('success', 'Event created successfully! It is pending approval.');
    }

    public function editEvent($id)
    {
        $event = Event::findOrFail($id);

        // Check if event belongs to current user
        if ($event->organizer_id != Auth::id()) {
            return redirect()->route('organizer.events')->with('error', 'You are not authorized to edit this event.');
        }

        // Check if event status is pending
        if ($event->status !== 'pending') {
            return redirect()->route('organizer.events')->with('error', 'Only pending events can be edited.');
        }

        return view('organizer.events.edit-event', compact('event'));
    }

    public function updateEvent(Request $request, $id)
    {
        $event = Event::findOrFail($id);

        // Check if event belongs to current user
        if ($event->organizer_id != Auth::id()) {
            return redirect()->route('organizer.events')->with('error', 'You are not authorized to edit this event.');
        }

        // Check if event status is pending
        if ($event->status !== 'pending') {
            return redirect()->route('organizer.events')->with('error', 'Only pending events can be edited.');
        }

        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => 'required|date',
            'location' => 'required|string|max:255',
            'organizer_name' => 'required|string|max:255',
            'poster' => 'nullable|image|max:2048',
            'qr_code' => 'nullable|image|max:2048',
            'payment_details' => 'nullable|string|max:1000',
            'supporting_docs' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'refund_type' => 'nullable|string|max:255',
            'refund_policy' => 'nullable|string|max:1000',
            'new_tickets' => 'nullable|array',
            'new_tickets.*.section' => 'required_with:new_tickets|string|max:255',
            'new_tickets.*.type' => 'required_with:new_tickets|string|max:255',
            'new_tickets.*.price' => 'required_with:new_tickets|numeric|min:0',
            'new_tickets.*.description' => 'nullable|string',
            'new_tickets.*.rows' => 'required_with:new_tickets|integer|min:1',
            'new_tickets.*.seats_per_row' => 'required_with:new_tickets|integer|min:1',
            'new_tickets.*.update_section' => 'nullable|string',
        ]);

        if ($request->hasFile('poster') && $request->file('poster')->isValid()) {
            // Delete old poster if it exists
            if ($event->poster) {
                Storage::disk('public')->delete($event->poster);
            }
            $posterPath = $request->file('poster')->store('posters', 'public');
            $event->poster = $posterPath;
        }

        if ($request->hasFile(key: 'qr_code') && $request->file('qr_code')->isValid()) {
            if ($event->qr_code) {
                Storage::disk('public')->delete($event->qr_code);
            }
            $qrcodePath = $request->file('qr_code')->store('qr_codes', 'public');
            $event->qr_code = $qrcodePath;
        }

        if ($request->hasFile('supporting_docs') && $request->file('supporting_docs')->isValid()) {
            // Delete old supporting docs if they exist
            if ($event->supporting_docs) {
                Storage::disk('public')->delete($event->supporting_docs);
            }
            $supportingDocsPath = $request->file('supporting_docs')->store('supporting_docs', 'public');
            $event->supporting_docs = $supportingDocsPath;
        }

        // Update event details
        $event->name = $request->input('name');
        $event->description = $request->input('description');
        $event->date = $request->input('date');
        $event->location = $request->input('location');
        $event->organizer_name = $request->input('organizer_name');
        $event->save();

        // Process new ticket sections
        if ($request->has('new_tickets')) {
            foreach ($request->new_tickets as $ticketData) {
                // Skip empty ticket sections
                if (empty($ticketData['section']) || empty($ticketData['type']) ||
                    ! isset($ticketData['price']) || empty($ticketData['rows']) ||
                    empty($ticketData['seats_per_row'])) {
                    continue;
                }

                // Check if this is an update to an existing section
                if (isset($ticketData['update_section'])) {
                    // Delete all available tickets in the section first
                    Ticket::where('eventId', $event->id)
                        ->where('section', $ticketData['update_section'])
                        ->where('status', 'available')
                        ->delete();

                    // Then create new tickets with the updated data
                    $section = $ticketData['section'];
                } else {
                    $section = $ticketData['section'];
                }

                // Create ticket types based on rows and seats per row
                $rows = $ticketData['rows'];
                $seatsPerRow = $ticketData['seats_per_row'];

                for ($row = 1; $row <= $rows; $row++) {
                    for ($seat = 1; $seat <= $seatsPerRow; $seat++) {
                        $ticket = new Ticket;
                        $ticket->eventId = $event->id;
                        $ticket->type = $ticketData['type'];
                        $ticket->price = $ticketData['price'];
                        $ticket->description = $ticketData['description'] ?? null;
                        $ticket->section = $section;
                        $ticket->row = $row;
                        $ticket->seat = $seat;
                        $ticket->status = 'available';
                        $ticket->save();
                    }
                }
            }
        }

        return redirect()->route('organizer.events')->with('success', 'Event updated successfully!');
    }

    public function deleteSection(Request $request, $eventId)
    {
        $event = Event::findOrFail($eventId);

        // Check if event belongs to current user
        if ($event->organizer_id != Auth::id()) {
            return redirect()->route('organizer.events')->with('error', 'You are not authorized to edit this event.');
        }

        // Check if event status is pending
        if ($event->status !== 'pending') {
            return redirect()->route('organizer.events')->with('error', 'Only pending events can be edited.');
        }

        // Validate the section name
        $request->validate([
            'section' => 'required|string',
        ]);

        $section = $request->input('section');

        // Check if any tickets in this section are sold
        $soldTickets = Ticket::where('eventId', $eventId)
            ->where('section', $section)
            ->where('status', '!=', 'available')
            ->exists();

        if ($soldTickets) {
            return redirect()->back()->with('error', 'Cannot delete section. Some tickets in this section have already been sold.');
        }

        // Delete all tickets in the section
        $deleted = Ticket::where('eventId', $eventId)
            ->where('section', $section)
            ->delete();

        if ($deleted) {
            return redirect()->back()->with('success', "Ticket section '$section' deleted successfully.");
        } else {
            return redirect()->back()->with('error', 'Failed to delete ticket section.');
        }
    }

    public function viewEvent($id)
    {
        $event = Event::find($id);
        if (! $event) {
            return redirect()->route('organizer.events')->with('error', 'Event not found.');
        }

        return view('organizer.events.view-event', compact('event'));
    }

    public function cancelEvent($id)
    {
        $event = Event::find($id);
        $event->status = 'canceled';
        $event->save();

        return redirect()->route('organizer.events');
    }

    /**
     * Show the manage bookings page.
     */
    public function manageBookings()
    {
        // Get the currently logged-in user (organizer)
        $user = Auth::user();

        // Get all events that belong to this organizer
        $events = Event::where('organizer_id', $user->id)->get();

        // Get event IDs for this organizer
        $eventIds = $events->pluck('id')->toArray();

        // Get all registrations for these events with pagination
        $registrations = EventRegistration::whereHas('event', function ($query) use ($user) {
            $query->where('organizer_id', $user->id);
        })
            ->with(['event', 'ticket', 'user'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('organizer.bookings.index', compact('registrations', 'events'));
    }

    /**
     * Approve a booking.
     */
    public function approveBooking($id)
    {
        $registration = EventRegistration::findOrFail($id);

        if ($registration->event->organizer_id != Auth::id()) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        $registration->status = 'approved';
        $registration->save();

        // Create attendance record with initial status
        Attendance::firstOrCreate(
            ['event_registration_id' => $registration->id],
            [
                'event_id' => $registration->event_id,
                'ticket_id' => $registration->ticket_id,
                'user_id' => $registration->user_id,
                'status' => Attendance::STATUS_REGISTERED,
            ]
        );

        return redirect()->back()->with('success', 'Booking approved.');
    }

    /**
     * Reject a booking.
     */
    public function rejectBooking($id)
    {
        $registration = EventRegistration::findOrFail($id);

        // Check if the event belongs to the current organizer
        if ($registration->event->organizer_id != Auth::id()) {
            return redirect()->back()->with('error', 'You are not authorized to manage this booking.');
        }

        $registration->status = 'rejected';
        $registration->save();

        return redirect()->back()->with('success', 'Booking has been rejected.');
    }

    /**
     * Reset a booking to pending status.
     */
    public function resetBooking($id)
    {
        $registration = EventRegistration::findOrFail($id);

        // Check if the event belongs to the current organizer
        if ($registration->event->organizer_id != Auth::id()) {
            return redirect()->back()->with('error', 'You are not authorized to manage this booking.');
        }

        $registration->status = 'pending';
        $registration->save();

        return redirect()->back()->with('success', 'Booking has been reset to pending status.');
    }

    public function showBooking($id)
    {
    $registration = EventRegistration::with(['event', 'ticket', 'payment'])
        ->findOrFail($id);

    if ($registration->event->organizer_id != Auth::id()) {
        abort(403, 'Unauthorized action.');
    }

    return view('organizer.bookings.show', compact('registration'));
    }
}
