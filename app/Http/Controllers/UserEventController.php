<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\EventRegistration;
use App\Models\Ticket; // Add Ticket model import

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
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'phone' => 'nullable|string|max:20',
        'ticket_id' => 'required|exists:tickets,id',
        'ticket_type' => 'required|string',
        'section' => 'required|string',
        'row' => 'required|string',
        'seat' => 'required|string',
    ]);

    // Verify that the ticket exists and is not already booked
    $ticket = Ticket::findOrFail($request->ticket_id);
    
    if($ticket->eventId != $event->id) {
        return back()->withErrors(['ticket_id' => 'Invalid ticket selection.'])->withInput();
    }
    
    // Check if ticket is already booked
    $existingRegistration = EventRegistration::where('ticket_id', $ticket->id)->first();
    if($existingRegistration) {
        return back()->withErrors(['ticket_id' => 'This ticket has already been booked.'])->withInput();
    }

    // Process the registration
    $registration = EventRegistration::create([
        'event_id' => $event->id,
        'ticket_id' => $request->ticket_id,
        'user_id' => auth()->id(), // Add the authenticated user's ID
        'name' => $request->name,
        'email' => $request->email,
        'phone' => $request->phone,
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
}