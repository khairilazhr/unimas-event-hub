<?php
namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Event;
use App\Models\EventRegistration;
use App\Models\ForumReply;
use App\Models\ForumTopic;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display the admin dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function dashboard()
    {
        // User statistics
        $userCount        = User::count();
        $organizerCount   = User::where('role', 'organizer')->count();
        $regularUserCount = User::where('role', 'user')->count();

        // Event statistics
        $eventCount       = Event::count();
        $activeEventCount = Event::where('status', 'active')->count();

        // Registration statistics
        $registrationCount = EventRegistration::count();

        // Forum statistics
        $forumTopicCount = ForumTopic::count();
        $forumReplyCount = ForumReply::count();

        // Recent events for dashboard
        $recentEvents = Event::latest()->take(5)->get();

        // Recent registrations for dashboard
        $recentRegistrations = EventRegistration::with('event')->latest()->take(5)->get();

        return view('admin.admin-dashboard', compact(
            'userCount', 'organizerCount', 'regularUserCount',
            'eventCount', 'activeEventCount',
            'registrationCount',
            'forumTopicCount', 'forumReplyCount',
            'recentEvents', 'recentRegistrations'
        ));
    }

    /**
     * Display a listing of users.
     *
     * @return \Illuminate\View\View
     */
    public function users(Request $request)
    {
        $query = User::query();

        // Filter by role if specified
        if ($request->has('role')) {
            $query->where('role', $request->role);
        }

        // Search by name or email
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for editing a user.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\View\View
     */
    public function editUser(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateUser(Request $request, User $user)
    {
        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role'  => 'required|string|in:admin,organizer,user',
        ]);

        $user->update($validated);

        return redirect()->route('admin.users')->with('success', 'User updated successfully.');
    }

    /**
     * Display a listing of events.
     *
     * @return \Illuminate\View\View
     */
    public function events(Request $request)
    {
        $query = Event::with('organizer');

        // Filter by status if specified
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        // Search by name or location
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%");
            });
        }

        $events = $query->latest()->paginate(10);

        return view('admin.events.index', compact('events'));
    }

    /**
     * Show the form for editing an event.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\View\View
     */
    public function editEvent(Event $event)
    {
        $organizers = User::where('role', 'organizer')->get();
        return view('admin.events.edit', compact('event', 'organizers'));
    }

    /**
     * Update the specified event.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateEvent(Request $request, Event $event)
    {
        $validated = $request->validate([
            'name'           => 'required|string|max:255',
            'description'    => 'required|string',
            'organizer_name' => 'required|string|max:255',
            'date'           => 'required|date',
            'location'       => 'required|string|max:255',
            'organizer_id'   => 'required|exists:users,id',
            'status'         => 'required|string|in:active,draft,cancelled',
        ]);

        // Handle poster upload if a new one is provided
        if ($request->hasFile('poster')) {
            $poster              = $request->file('poster');
            $posterPath          = $poster->store('posters', 'public');
            $validated['poster'] = $posterPath;
        }

        $event->update($validated);

        return redirect()->route('admin.events')->with('success', 'Event updated successfully.');
    }

    /**
     * Display a listing of tickets.
     *
     * @return \Illuminate\View\View
     */
    public function tickets(Request $request)
    {
        $query = Ticket::with('event');

        // Filter by event if specified
        if ($request->has('event_id')) {
            $query->where('eventId', $request->event_id);
        }

        // Filter by status if specified
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $tickets = $query->latest()->paginate(10);
        $events  = Event::all();

        return view('admin.tickets.index', compact('tickets', 'events'));
    }

    /**
     * Display a listing of registrations.
     *
     * @return \Illuminate\View\View
     */
    public function registrations(Request $request)
    {
        $query = EventRegistration::with(['event', 'ticket', 'user']);

        // Filter by event if specified
        if ($request->has('event_id')) {
            $query->where('event_id', $request->event_id);
        }

        // Filter by status if specified
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        // Search by name or email
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $registrations = $query->latest()->paginate(10);
        $events        = Event::all();

        return view('admin.registrations.index', compact('registrations', 'events'));
    }

    /**
     * Display a listing of forum topics.
     *
     * @return \Illuminate\View\View
     */
    public function forum(Request $request)
    {
        $query = ForumTopic::with(['event', 'user', 'replies']);

        // Filter by event if specified
        if ($request->has('event_id')) {
            $query->where('event_id', $request->event_id);
        }

        // Filter by resolved status if specified
        if ($request->has('is_resolved')) {
            $query->where('is_resolved', $request->is_resolved === 'true');
        }

        // Search by title or content
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $topics = $query->latest()->paginate(10);
        $events = Event::all();

        return view('admin.forum.index', compact('topics', 'events'));
    }

    /**
     * Display a listing of announcements.
     *
     * @return \Illuminate\View\View
     */
    public function announcements(Request $request)
    {
        $query = Announcement::with(['event']);

        // Filter by event if specified
        if ($request->has('event_id')) {
            $query->where('eventId', $request->event_id);
        }

        // Search by title or content
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $announcements = $query->latest()->paginate(10);
        $events        = Event::all();

        return view('admin.announcements.index', compact('announcements', 'events'));
    }

    /**
     * Show the form for creating a new announcement.
     *
     * @return \Illuminate\View\View
     */
    public function createAnnouncement()
    {
        $events = Event::all();
        return view('admin.announcements.create', compact('events'));
    }

    /**
     * Store a newly created announcement.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeAnnouncement(Request $request)
    {
        $validated = $request->validate([
            'eventId'           => 'required|exists:events,id',
            'title'             => 'required|string|max:255',
            'content'           => 'required|string',
            'announcement_date' => 'required|date',
        ]);

        $validated['created_by'] = auth()->id();

        Announcement::create($validated);

        return redirect()->route('admin.announcements')->with('success', 'Announcement created successfully.');
    }

    /**
     * Show the form for editing an announcement.
     *
     * @param  \App\Models\Announcement  $announcement
     * @return \Illuminate\View\View
     */
    public function editAnnouncement(Announcement $announcement)
    {
        $events = Event::all();
        return view('admin.announcements.edit', compact('announcement', 'events'));
    }

    /**
     * Update the specified announcement.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Announcement  $announcement
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateAnnouncement(Request $request, Announcement $announcement)
    {
        $validated = $request->validate([
            'eventId'           => 'required|exists:events,id',
            'title'             => 'required|string|max:255',
            'content'           => 'required|string',
            'announcement_date' => 'required|date',
        ]);

        $announcement->update($validated);

        return redirect()->route('admin.announcements')->with('success', 'Announcement updated successfully.');
    }

    /**
     * Remove the specified announcement.
     *
     * @param  \App\Models\Announcement  $announcement
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroyAnnouncement(Announcement $announcement)
    {
        $announcement->delete();
        return redirect()->route('admin.announcements')->with('success', 'Announcement deleted successfully.');
    }
}
