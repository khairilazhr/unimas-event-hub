<?php
namespace App\Http\Controllers;

use App\Mail\RegistrationStatusUpdateNotification;
use App\Models\Attendance;
use App\Models\Event;
use App\Models\EventRegistration;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

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
        $totalEvents       = $events->count();
        $upcomingEvents    = $events->where('status', 'upcoming')->count();

        // Placeholder logic
        $pendingPayments = 0;

        return view('organizer.organizer-dashboard', [
            'events'            => $events,
            'totalEvents'       => $totalEvents,
            'upcomingEvents'    => $upcomingEvents,
            'pendingPayments'   => $pendingPayments,
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
        $user   = Auth::user();
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
            'name'                    => 'required|string|max:255',
            'description'             => 'required|string',
            'date'                    => 'required|date',
            'location'                => 'required|string|max:255',
            'organizer_name'          => 'required|string|max:255',
            'poster'                  => 'nullable|image|max:2048',
            'qr_code'                 => 'nullable|image|max:2048',
            'payment_details'         => 'nullable|string|max:1000',
            'supporting_docs'         => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'refund_type'             => 'nullable|string|max:255',
            'refund_policy'           => 'nullable|string|max:1000',
            'tickets'                 => 'required|array|min:1',
            'tickets.*.section'       => 'required|string|max:255',
            'tickets.*.type'          => 'required|string|max:255',
            'tickets.*.price'         => 'required|numeric|min:0',
            'tickets.*.description'   => 'nullable|string',
            'tickets.*.rows'          => 'required|integer|min:1',
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

        $event                  = new Event;
        $event->name            = $request->input('name');
        $event->description     = $request->input('description');
        $event->date            = $request->input('date');
        $event->location        = $request->input('location');
        $event->organizer_name  = $request->input('organizer_name');
        $event->poster          = $posterPath;
        $event->qr_code         = $qrcodePath;
        $event->payment_details = $request->input('payment_details');
        $event->supporting_docs = $supportingDocsPath;
        $event->refund_type     = $request->input('refund_type');
        $event->refund_policy   = $request->input('refund_policy');
        $event->organizer_id    = Auth::id();
        $event->status          = 'pending';
        $event->save();

        // Process ticket sections
        if ($request->has('tickets')) {
            foreach ($request->tickets as $ticketData) {
                // Create ticket types based on rows and seats per row
                $rows        = $ticketData['rows'];
                $seatsPerRow = $ticketData['seats_per_row'];

                for ($row = 1; $row <= $rows; $row++) {
                    for ($seat = 1; $seat <= $seatsPerRow; $seat++) {
                        $ticket              = new Ticket;
                        $ticket->eventId     = $event->id; // Link ticket to event
                        $ticket->type        = $ticketData['type'];
                        $ticket->price       = $ticketData['price'];
                        $ticket->description = $ticketData['description'] ?? null;
                        $ticket->section     = $ticketData['section'];
                        $ticket->row         = $row;
                        $ticket->seat        = $seat;
                        $ticket->status      = 'available'; // Set initial status to available
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
            'name'            => 'required|string|max:255',
            'description'     => 'required|string',
            'date'            => 'required|date',
            'location'        => 'required|string|max:255',
            'organizer_name'  => 'required|string|max:255',
            'poster'          => 'nullable|image|max:2048',
            'qr_code'         => 'nullable|image|max:2048',
            'payment_details' => 'nullable|string|max:1000',
            'supporting_docs' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'refund_type'     => 'nullable|string|max:255',
            'refund_policy'   => 'nullable|string|max:1000',
        ]);

        // Handle file uploads
        if ($request->hasFile('poster') && $request->file('poster')->isValid()) {
            // Delete old poster if it exists
            if ($event->poster) {
                Storage::disk('public')->delete($event->poster);
            }
            $posterPath    = $request->file('poster')->store('posters', 'public');
            $event->poster = $posterPath;
        }

        if ($request->hasFile('qr_code') && $request->file('qr_code')->isValid()) {
            if ($event->qr_code) {
                Storage::disk('public')->delete($event->qr_code);
            }
            $qrcodePath     = $request->file('qr_code')->store('qr_codes', 'public');
            $event->qr_code = $qrcodePath;
        }

        if ($request->hasFile('supporting_docs') && $request->file('supporting_docs')->isValid()) {
            // Delete old supporting docs if they exist
            if ($event->supporting_docs) {
                Storage::disk('public')->delete($event->supporting_docs);
            }
            $supportingDocsPath     = $request->file('supporting_docs')->store('supporting_docs', 'public');
            $event->supporting_docs = $supportingDocsPath;
        }

        // Update all event details (including the missing fields)
        $event->name           = $request->input('name');
        $event->description    = $request->input('description');
        $event->date           = $request->input('date');
        $event->location       = $request->input('location');
        $event->organizer_name = $request->input('organizer_name');

        // Add these missing field updates
        $event->payment_details = $request->input('payment_details');
        $event->refund_type     = $request->input('refund_type');
        $event->refund_policy   = $request->input('refund_policy');

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
                $rows        = $ticketData['rows'];
                $seatsPerRow = $ticketData['seats_per_row'];

                for ($row = 1; $row <= $rows; $row++) {
                    for ($seat = 1; $seat <= $seatsPerRow; $seat++) {
                        $ticket              = new Ticket;
                        $ticket->eventId     = $event->id;
                        $ticket->type        = $ticketData['type'];
                        $ticket->price       = $ticketData['price'];
                        $ticket->description = $ticketData['description'] ?? null;
                        $ticket->section     = $section;
                        $ticket->row         = $row;
                        $ticket->seat        = $seat;
                        $ticket->status      = 'available';
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

        // Group tickets by type
        $groupedTickets = $event->tickets->groupBy('type');

        return view('organizer.events.view-event', compact('event', 'groupedTickets'));
    }

    public function cancelEvent($id)
    {
        $event         = Event::find($id);
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
    public function approveBooking($registrationId)
    {
        $registration = EventRegistration::findOrFail($registrationId);

        // Update registration status
        $registration->status = 'approved';
        $registration->save();

        // Update associated ticket status
        if ($registration->ticket) {
            $ticket         = Ticket::find($registration->ticket_id);
            $ticket->status = 'confirmed';
            $ticket->save();
        }

        // Send email notification to the user
        try {
            Mail::to($registration->email)->send(new RegistrationStatusUpdateNotification($registration, 'approved'));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Failed to send approval email: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Booking approved successfully');
    }

    public function rejectBooking($registrationId)
    {
        $registration = EventRegistration::findOrFail($registrationId);

        // Update registration status
        $registration->status = 'rejected';
        $registration->save();

        // Update associated ticket status
        if ($registration->ticket) {
            $ticket         = Ticket::find($registration->ticket_id);
            $ticket->status = 'available';
            $ticket->save();
        }

        // Send email notification to the user
        try {
            Mail::to($registration->email)->send(new RegistrationStatusUpdateNotification($registration, 'rejected'));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Failed to send rejection email: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Booking rejected successfully');
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

    public function bookingsReport(Request $request)
    {
        $user = Auth::user();

        // Get all registrations for this organizer's events
        $registrations = EventRegistration::whereHas('event', function ($query) use ($user) {
            $query->where('organizer_id', $user->id);
        })
            ->with(['event', 'ticket', 'user'])
            ->orderBy('status')
            ->orderBy('created_at', 'desc')
            ->get();

        $statuses = ['approved', 'pending', 'rejected'];

        $response = new StreamedResponse(function () use ($registrations, $statuses) {
            $handle = fopen('php://output', 'w');
            // CSV Header
            fputcsv($handle, [
                'Status', 'Event', 'Event Date', 'Ticket Type', 'Section', 'Row', 'Seat',
                'Attendee Name', 'User ID', 'Email', 'Phone', 'Registered At',
            ]);

            foreach ($statuses as $status) {
                $filtered = $registrations->where('status', $status);
                foreach ($filtered as $reg) {
                    fputcsv($handle, [
                        ucfirst($reg->status),
                        $reg->event->name ?? '',
                        $reg->event->date ?? '',
                        $reg->ticket->type ?? '',
                        $reg->ticket->section ?? '',
                        $reg->ticket->row ?? '',
                        $reg->ticket->seat ?? '',
                        $reg->name,
                        $reg->user ? $reg->user->id : 'Guest',
                        $reg->email,
                        $reg->phone,
                        $reg->created_at->format('Y-m-d H:i'),
                    ]);
                }
            }
            fclose($handle);
        });

        $filename = 'event_bookings_report_' . now()->format('Ymd_His') . '.csv';
        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', "attachment; filename=\"$filename\"");

        return $response;
    }

    public function dashboardReport()
    {
        $user = Auth::user();

        // Get organizer's events
        $events = Event::where('organizer_id', $user->id)->get();

        // Calculate statistics
        $totalEvents       = $events->count();
        $upcomingEvents    = $events->where('date', '>', now())->count();
        $completedEvents   = $events->where('date', '<', now())->count();
        $totalParticipants = EventRegistration::whereIn('event_id', $events->pluck('id'))->count();
        $totalRevenue      = EventRegistration::whereIn('event_id', $events->pluck('id'))
            ->where('status', 'approved')
            ->sum('amount_paid');

        // Generate CSV
        $response = new StreamedResponse(function () use ($events, $totalEvents, $upcomingEvents, $completedEvents, $totalParticipants, $totalRevenue) {
            $handle = fopen('php://output', 'w');

            // Write header
            fputcsv($handle, ['Organizer Performance Report']);
            fputcsv($handle, ['Generated at:', now()->format('Y-m-d H:i:s')]);
            fputcsv($handle, []);

            // Summary Statistics
            fputcsv($handle, ['Summary Statistics']);
            fputcsv($handle, ['Total Events', $totalEvents]);
            fputcsv($handle, ['Upcoming Events', $upcomingEvents]);
            fputcsv($handle, ['Completed Events', $completedEvents]);
            fputcsv($handle, ['Total Participants', $totalParticipants]);
            fputcsv($handle, ['Total Revenue', 'RM ' . number_format($totalRevenue, 2)]);
            fputcsv($handle, []);

            // Events Breakdown
            fputcsv($handle, ['Event Details']);
            fputcsv($handle, ['Event Name', 'Date', 'Status', 'Registrations', 'Revenue']);

            foreach ($events as $event) {
                $eventRegistrations = $event->registrations()->count();
                $eventRevenue       = $event->registrations()
                    ->where('status', 'approved')
                    ->sum('amount_paid');

                fputcsv($handle, [
                    $event->name,
                    $event->date,
                    $event->status,
                    $eventRegistrations,
                    'RM ' . number_format($eventRevenue, 2),
                ]);
            }

            // Monthly Trends
            fputcsv($handle, []);
            fputcsv($handle, ['Monthly Registration Trends']);
            fputcsv($handle, ['Month', 'Registrations', 'Revenue']);

            $monthlyStats = EventRegistration::whereIn('event_id', $events->pluck('id'))
                ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month')
                ->selectRaw('COUNT(*) as registrations')
                ->selectRaw('SUM(amount_paid) as revenue')
                ->groupBy('month')
                ->orderBy('month', 'desc')
                ->get();

            foreach ($monthlyStats as $stat) {
                fputcsv($handle, [
                    $stat->month,
                    $stat->registrations,
                    'RM ' . number_format($stat->revenue, 2),
                ]);
            }

            fclose($handle);
        });

        $filename = 'organizer_performance_report_' . now()->format('Ymd_His') . '.csv';
        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', "attachment; filename=\"$filename\"");

        return $response;
    }

    public function manageAttendances()
    {
        $user = Auth::user();

        // Get all events for this organizer
        $events = Event::where('organizer_id', $user->id)
            ->orderBy('date', 'desc')
            ->get();

        return view('organizer.attendances.index', compact('events'));
    }

    public function markAttendance(Request $request, $registrationId)
    {
        try {
            $registration = EventRegistration::findOrFail($registrationId);

            // Check if the event belongs to the current organizer
            if ($registration->event->organizer_id != auth()->id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized action',
                ], 403);
            }

            // Check if attendance record exists
            $attendance = Attendance::firstOrCreate(
                ['event_registration_id' => $registration->id],
                ['status' => Attendance::STATUS_REGISTERED]
            );

            // Update attendance status
            $attendance->update([
                'status'      => Attendance::STATUS_ATTENDED,
                'attended_at' => now(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Attendance marked successfully',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to mark attendance: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function attendanceHistory(Request $request)
    {
        $user = Auth::user();

        // Get all events for this organizer
        $events = Event::where('organizer_id', $user->id)
            ->orderBy('date', 'desc')
            ->get();

        // Get selected event filter
        $selectedEventId = $request->get('event_id');

        // Build the base query for registrations
        $baseQuery = EventRegistration::whereHas('event', function ($query) use ($user) {
            $query->where('organizer_id', $user->id);
        })
            ->with(['event', 'ticket', 'user', 'attendance'])
            ->where('status', 'approved');

        // Apply event filter if selected
        if ($selectedEventId) {
            $baseQuery->where('event_id', $selectedEventId);
        }

        // Get paginated results for display
        $registrations = $baseQuery->orderBy('created_at', 'desc')->paginate(15);

        // Get total statistics from the entire filtered dataset (not just current page)
        $totalRegistrations = $baseQuery->count();
        $attendedCount      = $baseQuery->whereHas('attendance', function ($query) {
            $query->where('status', 'attended');
        })->count();
        $notAttendedCount = $totalRegistrations - $attendedCount;

        return view('organizer.attendances.history', compact(
            'registrations',
            'events',
            'selectedEventId',
            'totalRegistrations',
            'attendedCount',
            'notAttendedCount'
        ));
    }
}
