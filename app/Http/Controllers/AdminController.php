<?php
namespace App\Http\Controllers;

use App\Models\Event;
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
        $eventCount         = Event::count();
        $pendingEventCount  = Event::where('status', 'pending')->count();
        $approvedEventCount = Event::where('status', 'approved')->count();

        // Recent events for dashboard
        $recentEvents = Event::latest()->take(5)->get();

        return view('admin.admin-dashboard', compact(
            'userCount', 'organizerCount', 'regularUserCount',
            'eventCount', 'pendingEventCount', 'approvedEventCount',
            'recentEvents'
        ));
    }

    // User Management Methods
    public function users(Request $request)
    {
        $query = User::query();

        if ($request->has('role')) {
            $query->where('role', $request->role);
        }

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
}
