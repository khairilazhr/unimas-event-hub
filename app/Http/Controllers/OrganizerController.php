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

        // Retrieve events for the current organizer
        $events = Event::where('organizer_id', $user->id)
        ->withCount('registrations') // This adds a `registrations_count` field
        ->orderBy('date', 'asc')
        ->get();
    
    // Now, you can sum up all participants from all events
        $totalParticipants = $events->sum('registrations_count');

        // Calculate dashboard statistics
        $totalEvents = $events->count();
        $upcomingEvents = $events->filter(function ($event) {
            return Carbon::parse($event->date)->isFuture();
        })->count();

        // Placeholder logic for additional statistics
        $pendingPayments = 0; // Replace with actual payment logic

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
}