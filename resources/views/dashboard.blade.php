@php
    use Carbon\Carbon;
    $today = Carbon::now();

    // Get announcements for the current user
    $userAnnouncements = \App\Models\Announcement::whereIn('eventId', function ($query) {
        $query
            ->select('event_id')
            ->from('event_registrations')
            ->where('user_id', auth()->id());
    })
        ->latest()
        ->get();

    // Get user's event registrations and stats
$userRegistrations = \App\Models\EventRegistration::where('user_id', auth()->id())
    ->with('event')
        ->latest()
        ->get();

    $totalEvents = $userRegistrations->count();
    $upcomingEvents = $userRegistrations
        ->filter(function ($registration) {
            return $registration->event && Carbon::parse($registration->event->event_date)->isFuture();
        })
        ->count();

    $recentRegistrations = $userRegistrations->take(3);
@endphp

<x-app-layout>
    <div class="dashboard-container">
        <main class="dashboard-main">
            <div class="dashboard-content">

                <!-- Dashboard Title -->
                <div class="dashboard-title">
                    <h1>Welcome back, {{ auth()->user()->name }}!</h1>
                    <p>Here's what's happening with your events</p>
                </div>

                <!-- Quick Stats -->
                <div class="dashboard-quick-stats">
                    <div class="dashboard-stat-card">
                        <div class="dashboard-stat-icon-row">
                            <div class="dashboard-stat-icon dashboard-stat-icon-blue">
                                <svg class="dashboard-stat-svg dashboard-stat-svg-blue" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                            </div>
                            <div class="dashboard-stat-info">
                                <p>Total Events</p>
                                <p>{{ $totalEvents }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="dashboard-stat-card">
                        <div class="dashboard-stat-icon-row">
                            <div class="dashboard-stat-icon dashboard-stat-icon-green">
                                <svg class="dashboard-stat-svg dashboard-stat-svg-green" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="dashboard-stat-info">
                                <p>Upcoming Events</p>
                                <p>{{ $upcomingEvents }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="dashboard-stat-card">
                        <div class="dashboard-stat-icon-row">
                            <div class="dashboard-stat-icon dashboard-stat-icon-purple">
                                <svg class="dashboard-stat-svg dashboard-stat-svg-purple" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 17h5l-5 5v-5zM4 19h6v-2H4v2zM4 15h6v-2H4v2zM4 11h6V9H4v2zM4 7h6V5H4v2zM10 7h10V5H10v2zM10 11h10V9H10v2zM10 15h10v-2H10v2z">
                                    </path>
                                </svg>
                            </div>
                            <div class="dashboard-stat-info">
                                <p>Announcements</p>
                                <p>{{ $userAnnouncements->count() }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity & Quick Actions -->
                <div class="dashboard-activity-actions">
                    <!-- Recent Activity -->
                    <div class="dashboard-activity">
                        <div class="dashboard-activity-header">
                            <h3>Recent Activity</h3>
                            <a href="{{ route('user.events.my-bookings') }}" class="dashboard-link">View All</a>
                        </div>

                        <div class="dashboard-activity-list">
                            @forelse ($recentRegistrations as $registration)
                                <div class="dashboard-activity-item">
                                    <div class="dashboard-activity-avatar">
                                        <div class="dashboard-activity-avatar-icon">
                                            <svg class="dashboard-activity-avatar-svg" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                </path>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="dashboard-activity-info">
                                        <p class="dashboard-activity-title">
                                            {{ $registration->event->title ?? 'Event' }}
                                        </p>
                                        <p class="dashboard-activity-date">
                                            Registered on
                                            {{ Carbon::parse($registration->created_at)->format('M d, Y') }}
                                        </p>
                                    </div>
                                    <div class="dashboard-activity-status">
                                        <span class="dashboard-activity-status-badge">
                                            Registered
                                        </span>
                                    </div>
                                </div>
                            @empty
                                <div class="dashboard-activity-empty">
                                    <svg class="dashboard-activity-empty-svg" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                    <p>No recent activity</p>
                                    <a href="{{ route('events.index') }}" class="dashboard-link">
                                        Browse events
                                    </a>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="dashboard-quick-actions">
                        <h3>Quick Actions</h3>

                        <div class="dashboard-quick-actions-list">
                            <a href="{{ route('user.events') }}" class="dashboard-quick-action browse-events">
                                <div class="dashboard-quick-action-icon dashboard-quick-action-icon-blue">
                                    <svg class="dashboard-quick-action-svg dashboard-quick-action-svg-blue"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </div>
                                <div class="dashboard-quick-action-info">
                                    <p>Browse Events</p>
                                    <p>Discover new events to attend</p>
                                </div>
                            </a>

                            <a href="{{ route('user.events.my-bookings') }}" class="dashboard-quick-action my-bookings">
                                <div class="dashboard-quick-action-icon dashboard-quick-action-icon-green">
                                    <svg class="dashboard-quick-action-svg dashboard-quick-action-svg-green"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                        </path>
                                    </svg>
                                </div>
                                <div class="dashboard-quick-action-info">
                                    <p>My Bookings</p>
                                    <p>View your event registrations</p>
                                </div>
                            </a>

                            <a href="{{ route('user.events.my-attendances') }}"
                                class="dashboard-quick-action my-attendances">
                                <div class="dashboard-quick-action-icon dashboard-quick-action-icon-purple">
                                    <svg class="dashboard-quick-action-svg dashboard-quick-action-svg-purple"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div class="dashboard-quick-action-info">
                                    <p>My Attendances</p>
                                    <p>View your event attendance history</p>
                                </div>
                            </a>

                            <a href="{{ route('profile.edit') }}" class="dashboard-quick-action profile-settings">
                                <div class="dashboard-quick-action-icon dashboard-quick-action-icon-gray">
                                    <svg class="dashboard-quick-action-svg dashboard-quick-action-svg-gray"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                        </path>
                                    </svg>
                                </div>
                                <div class="dashboard-quick-action-info">
                                    <p>Profile Settings</p>
                                    <p>Update your account information</p>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Announcement Section -->
                <div class="dashboard-announcement-section">
                    <!-- Header -->
                    <div class="dashboard-announcement-header">
                        <h3>Announcements</h3>
                        <p>Stay updated with the latest news and activities.</p>
                    </div>

                    <!-- Announcement Cards Section -->
                    <div class="dashboard-announcement-cards">
                        @forelse ($userAnnouncements as $announcement)
                            <div class="dashboard-announcement-card">
                                <div class="dashboard-announcement-card-row">
                                    <div class="dashboard-announcement-card-event">
                                        <span>Event</span>
                                    </div>
                                    <div class="dashboard-announcement-card-info">
                                        <h4>{{ $announcement->title }}</h4>
                                        <p>{{ $announcement->content }}</p>
                                        @if ($announcement->announcement_date)
                                            <p>Date:
                                                {{ \Carbon\Carbon::parse($announcement->announcement_date)->format('d/m/Y') }}
                                            </p>
                                        @endif
                                        @if ($announcement->created_by)
                                            <p>By:
                                                {{ $announcement->created_by }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="dashboard-announcement-empty">
                                <p>No announcements available for your registered events.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>
        </main>

        <footer class="dashboard-footer">
            <div class="dashboard-footer-content">
                <div class="dashboard-footer-grid">
                    <div>
                        <div class="dashboard-footer-title">EventHub</div>
                        <p class="dashboard-footer-desc">
                            Bringing people together through memorable events and experiences.
                        </p>
                    </div>
                    <div>
                        <h3 class="dashboard-footer-help-title">Need Help?</h3>
                        <p class="dashboard-footer-help-desc">
                            Have questions or need assistance? Our support team is here to help you.
                        </p>
                        <button class="dashboard-footer-help-btn">
                            <svg class="dashboard-footer-help-btn-svg" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z">
                                </path>
                            </svg>
                            Contact Support
                        </button>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</x-app-layout>
