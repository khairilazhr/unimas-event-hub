<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\EventRegistration;

class UserEventController extends Controller
{
    public function index()
    {
        $events = Event::latest()->paginate(6); // Show 6 events per page
        return view('events.index', compact('events'));
    }
    
    public function showRegistrationForm(Event $event)
    {
        return view('events.register', compact('event'));
    }
    
    public function processRegistration(Request $request, Event $event)
    {
        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'notes' => 'nullable|string|max:1000',
        ]);
        
        // Process the registration
        $event->registrations()->create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'notes' => $request->notes,
        ]);
        
        // Redirect with success message
        return redirect()->route('user.events.index')
            ->with('success', 'You have successfully registered for this event!');
    }
}