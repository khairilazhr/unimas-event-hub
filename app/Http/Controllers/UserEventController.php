<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventRegistration;
use App\Models\Ticket;
use Illuminate\Http\Request;
// Add Ticket model import

class UserEventController extends Controller
{
    public function index()
    {
        $events = Event::latest()->paginate(6); // Show 6 events per page
        return view('events.index', compact('events'));
    }

    public function showRegistrationForm(Event $event)
    {
        // Fetch tickets associated with this event
        $tickets = Ticket::where('eventId', $event->id)->get();

        // Get authenticated user
        $user = auth()->user();

        return view('events.register', compact('event', 'tickets'));
    }

    public function processRegistration(Request $request, Event $event)
    {
        // Validate the request
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => 'required|email|max:255',
            'phone'       => 'nullable|string|max:20',
            'ticket_id'   => 'required|exists:tickets,id',
            'ticket_type' => 'required|string',
            'section'     => 'required|string',
            'row'         => 'required|string',
            'seat'        => 'required|string',
        ]);

        // Verify that the ticket exists and is not already booked
        $ticket = Ticket::findOrFail($request->ticket_id);

        if ($ticket->eventId != $event->id) {
            return back()->withErrors(['ticket_id' => 'Invalid ticket selection.'])->withInput();
        }

        // Check if ticket is already booked
        $existingRegistration = EventRegistration::where('ticket_id', $ticket->id)->first();
        if ($existingRegistration) {
            return back()->withErrors(['ticket_id' => 'This ticket has already been booked.'])->withInput();
        }

        // Set status based on ticket price
        $status = $ticket->price > 0 ? 'pending' : 'confirmed';

        // Process the registration
        $registration = EventRegistration::create([
            'event_id'  => $event->id,
            'ticket_id' => $request->ticket_id,
            'user_id'   => auth()->id(),
            'name'      => $request->name,
            'email'     => $request->email,
            'phone'     => $request->phone,
            'status'    => $status, // Add status field
        ]);

        // Redirect to success page
        return redirect()->route('user.events.registration-success', $registration->id);
    }

    public function registrationSuccess(EventRegistration $registration)
    {
        // Load the event and ticket relations
        $registration->load(['event', 'ticket']);

        return view('events.registration-success', compact('registration'));
    }

    public function myBookings()
    {
        // Get the authenticated user
        $user = auth()->user();

        // Get all registrations for this user with related event and ticket data
        $registrations = EventRegistration::where('user_id', $user->id)
            ->with(['event', 'ticket'])
            ->latest()
            ->get();

        return view('events.my-bookings', compact('registrations'));
    }
    public function registrationDetails(EventRegistration $registration)
    {
        // Security check - only allow users to view their own registrations
        if ($registration->user_id != auth()->id()) {
            abort(403, 'You are not authorized to view this registration.');
        }

        // Load the event and ticket relations
        $registration->load(['event', 'ticket']);

        return view('events\registation-details', compact('registration'));
    }

    public function cancelRegistration(EventRegistration $registration)
    {
        // Security check - only allow users to cancel their own registrations
        if ($registration->user_id != auth()->id()) {
            abort(403, 'You are not authorized to cancel this registration.');
        }

        // Check if the event date is in the future
        if (! \Carbon\Carbon::parse($registration->event->date)->isFuture()) {
            return back()->withErrors(['message' => 'You cannot cancel a registration for a past event.']);
        }

        // Update registration status to cancelled
        $registration->status = 'cancelled';
        $registration->save();

        return redirect()->route('user.events.my-bookings')
            ->with('success', 'Your booking has been cancelled successfully.');
    }

    public function verifyTicket($id)
    {
        $registration = EventRegistration::with(['event', 'ticket'])
            ->findOrFail($id);

        // Check if the ticket is valid
        $isValid = $registration->status === 'confirmed';

        // Additional checks can be added here
        // For example, check if the event date is in the future
        $eventInFuture = \Carbon\Carbon::parse($registration->event->date)->isFuture();

        return response()->json([
            'valid'        => $isValid,
            'registration' => [
                'id'     => $registration->id,
                'status' => $registration->status,
                'name'   => $registration->name,
                'event'  => [
                    'name'     => $registration->event->name,
                    'date'     => \Carbon\Carbon::parse($registration->event->date)->format('d M Y, h:i A'),
                    'location' => $registration->event->location,
                ],
                'ticket' => [
                    'type'    => $registration->ticket->type,
                    'section' => $registration->ticket->section,
                    'row'     => $registration->ticket->row,
                    'seat'    => $registration->ticket->seat,
                ],
            ],
        ]);
    }

}
