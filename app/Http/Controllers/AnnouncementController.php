<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcement::orderBy('created_at', 'desc')->get();

        return view('organizer.announcements.index', compact('announcements'));
    }

    public function create()
    {
        $events = Event::all(); // Fetch all events from the database

        return view('organizer.announcements.create', compact('events'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'eventId' => 'required|exists:events,id',
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
        ]);

        Announcement::create([
            'eventId' => $request->eventId,
            'title' => $request->title,
            'content' => $request->content,
            'announcement_date' => now(),
            'created_by' => Auth::user()->name,
        ]);

        return redirect()->route('announcements.index')->with('success', 'Announcement created successfully.');
    }

    public function edit(Announcement $announcement)
    {
        return view('organizer.announcements.edit', compact('announcement'));
    }

    public function update(Request $request, Announcement $announcement)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'announcement_date' => 'nullable|date',
        ]);

        $announcement->update([
            'title' => $request->title,
            'content' => $request->content,
            'announcement_date' => $request->announcement_date,
        ]);

        return redirect()->route('announcements.index')->with('success', 'Announcement updated successfully.');
    }

    public function destroy(Announcement $announcement)
    {
        $announcement->delete();

        return redirect()->route('announcements.index')->with('success', 'Announcement deleted successfully.');
    }
}
