<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;

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
            'totalParticipants' => $totalParticipants
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
        $event = new Event();
        $event->name = $request->input('name');
        $event->description = $request->input('description');
        $event->organizer_id = Auth::id();
        $event->status = 'pending';
        $event->save();
        return redirect()->route('organizer.events');
    }

    public function editEvent($id)
    {
        $event = Event::find($id);
        if ($event->status !== 'approved') {
            return back()->withErrors(['You can only edit approved events.']);
        }
        return view('organizer.events.edit-event', compact('event'));
    }

    public function updateEvent(Request $request, $id)
    {
        $event = Event::find($id);
        if ($event->status !== 'approved') {
            return back()->withErrors(['You can only edit approved events.']);
        }
        $event->name = $request->input('name');
        $event->description = $request->input('description');
        $event->save();
        return redirect()->route('organizer.events');
    }

    public function viewEvent($id)
    {
        $event = Event::find($id);
        return view('organizer.events.view-event', compact('event'));
    }

    public function cancelEvent($id)
    {
        $event = Event::find($id);
        $event->status = 'canceled';
        $event->save();
        return redirect()->route('organizer.events');
    }
}