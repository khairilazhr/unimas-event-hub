<?php
namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventRegistration;
use App\Models\ForumReply;
use App\Models\ForumTopic;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        // User statistics
        $userCount        = User::count();
        $organizerCount   = User::where('role', 'organizer')->count();
        $regularUserCount = $userCount - $organizerCount;

        // Event statistics
        $eventCount        = Event::count();
        $activeEventCount  = Event::where('status', 'approved')->count();
        $pendingEventCount = Event::where('status', 'pending')->count();

        // Registration statistics
        $registrationCount = EventRegistration::count();

        // Forum statistics
        $forumTopicCount = ForumTopic::count();
        $forumReplyCount = ForumReply::count();

        // Recent activities
        $recentEvents        = Event::with('organizer')->latest()->take(5)->get();
        $recentRegistrations = EventRegistration::with(['event', 'user'])->latest()->take(5)->get();

        return view('admin.admin-dashboard', compact(
            'userCount',
            'organizerCount',
            'regularUserCount',
            'eventCount',
            'activeEventCount',
            'pendingEventCount',
            'registrationCount',
            'forumTopicCount',
            'forumReplyCount',
            'recentEvents',
            'recentRegistrations'
        ));
    }

    // User Management Methods
    public function users(Request $request)
    {
        $query = User::query();

        // Filter by role
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

        $users = $query->latest()->paginate(10);

        // Get counts for filter badges (unfiltered)
        $totalCount       = User::count();
        $organizerCount   = User::where('role', 'organizer')->count();
        $regularUserCount = $totalCount - $organizerCount;

        return view('admin.users.index', compact(
            'users',
            'totalCount',
            'organizerCount',
            'regularUserCount'
        ));
    }

    public function editUser(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

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

    public function destroyUser(User $user)
    {
        // Prevent admin from deleting themselves
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users')->with('error', 'You cannot delete your own account.');
        }

        // Check if user has any related data
        $hasEvents        = $user->events()->exists();
        $hasRegistrations = $user->eventRegistrations()->exists();

        if ($hasEvents || $hasRegistrations) {
            return redirect()->route('admin.users')->with('error', 'Cannot delete user. User has associated events or registrations.');
        }

        $user->delete();

        return redirect()->route('admin.users')->with('success', 'User deleted successfully.');
    }

    // Event Management Methods
    public function events(Request $request)
    {
        $tab = $request->input('tab', 'pending');

        $query = Event::with('organizer')
            ->when($tab === 'pending', function ($q) {
                $q->where('status', 'pending');
            })
            ->when($tab === 'processed', function ($q) {
                $q->whereIn('status', ['approved', 'rejected']);
            });

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%");
            });
        }

        // Get counts for tabs
        $pendingCount   = Event::where('status', 'pending')->count();
        $processedCount = Event::whereIn('status', ['approved', 'rejected'])->count();

        $events = $query->latest()->paginate(10);

        return view('admin.events.index', compact(
            'events',
            'pendingCount',
            'processedCount',
            'tab'
        ));
    }

    public function approveEvent(Event $event)
    {
        $event->update(['status' => 'approved']);

        return redirect()->route('admin.events')->with('success', 'Event approved successfully.');
    }

    public function rejectEvent(Event $event)
    {
        $event->update(['status' => 'rejected']);

        return redirect()->route('admin.events')->with('success', 'Event rejected successfully.');
    }

    public function showEvent(Event $event)
    {
        $event->load(['organizer', 'tickets.registrations', 'tickets.refunds', 'registrations.user', 'forumTopics.user', 'questionnaires']);

        // Group tickets by type
        $groupedTickets = $event->tickets->groupBy('type')->map(function ($tickets) {
            $firstTicket = $tickets->first();
            return [
                'type'                => $firstTicket->type,
                'price'               => $firstTicket->price,
                'description'         => $firstTicket->description,
                'count'               => $tickets->count(),
                'total_registrations' => $tickets->sum(function ($ticket) {
                    return $ticket->registrations->count();
                }),
                'total_refunds'       => $tickets->sum(function ($ticket) {
                    return $ticket->refunds->count();
                }),
                'sections'            => $tickets->unique('section')->pluck('section')->toArray(),
            ];
        });

        return view('admin.events.show', compact('event', 'groupedTickets'));
    }
}
