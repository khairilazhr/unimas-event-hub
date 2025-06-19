<!-- resources/views/admin/admin-dashboard.blade.php -->
<x-app-layout>
    <div class="min-h-screen flex flex-col">
        <main class="flex-grow py-6 sm:py-8 md:py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 shadow-lg sm:rounded-xl overflow-hidden">
                    <!-- Header Section -->
                    <div class="relative bg-unimasblue dark:bg-unimasblue p-6">
                        <div class="absolute inset-0 opacity-10 bg-pattern-grid"></div>
                        <h1 class="text-2xl sm:text-3xl font-bold text-center text-white">
                            {{ __('Admin Dashboard') }}
                        </h1>
                    </div>

                    <!-- Stats Overview -->
                    <div class="p-4 sm:p-6 md:p-8">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                            <!-- Total Users Card -->
                            <div class="bg-white dark:bg-gray-700 p-6 rounded-xl shadow-sm">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h3 class="text-lg font-medium text-gray-500 dark:text-gray-400">Total Users
                                        </h3>
                                        <p class="text-3xl font-bold mt-2 text-gray-900 dark:text-white">
                                            {{ $userCount }}</p>
                                    </div>
                                    <div class="bg-blue-100 dark:bg-blue-800 p-3 rounded-lg">
                                        <svg class="w-6 h-6 text-blue-600 dark:text-blue-300" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="mt-4 flex justify-between text-sm text-gray-500 dark:text-gray-400">
                                    <span>{{ $organizerCount }} Organizers</span>
                                    <span>{{ $regularUserCount }} Regular</span>
                                </div>
                            </div>

                            <!-- Total Events Card -->
                            <div class="bg-white dark:bg-gray-700 p-6 rounded-xl shadow-sm">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h3 class="text-lg font-medium text-gray-500 dark:text-gray-400">Total Events
                                        </h3>
                                        <p class="text-3xl font-bold mt-2 text-gray-900 dark:text-white">
                                            {{ $eventCount }}</p>
                                    </div>
                                    <div class="bg-green-100 dark:bg-green-800 p-3 rounded-lg">
                                        <svg class="w-6 h-6 text-green-600 dark:text-green-300" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="mt-4 text-sm text-gray-500 dark:text-gray-400">
                                    {{ $activeEventCount }} Active Events
                                </div>
                            </div>

                            <!-- Registrations Card -->
                            <div class="bg-white dark:bg-gray-700 p-6 rounded-xl shadow-sm">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h3 class="text-lg font-medium text-gray-500 dark:text-gray-400">Registrations
                                        </h3>
                                        <p class="text-3xl font-bold mt-2 text-gray-900 dark:text-white">
                                            {{ $registrationCount }}</p>
                                    </div>
                                    <div class="bg-purple-100 dark:bg-purple-800 p-3 rounded-lg">
                                        <svg class="w-6 h-6 text-purple-600 dark:text-purple-300" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <!-- Forum Activity Card -->
                            <div class="bg-white dark:bg-gray-700 p-6 rounded-xl shadow-sm">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h3 class="text-lg font-medium text-gray-500 dark:text-gray-400">Forum Activity
                                        </h3>
                                        <p class="text-3xl font-bold mt-2 text-gray-900 dark:text-white">
                                            {{ $forumTopicCount }}</p>
                                    </div>
                                    <div class="bg-red-100 dark:bg-red-800 p-3 rounded-lg">
                                        <svg class="w-6 h-6 text-red-600 dark:text-red-300" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="mt-4 text-sm text-gray-500 dark:text-gray-400">
                                    {{ $forumReplyCount }} Replies
                                </div>
                            </div>
                        </div>

                        <!-- Quick Access Panels -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                            <!-- Recent Events -->
                            <div class="bg-white dark:bg-gray-700 p-6 rounded-xl shadow-sm">
                                <div class="flex items-center justify-between mb-4">
                                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">Recent Events</h3>
                                    <a href="{{ route('admin.events') }}"
                                        class="text-blue-600 dark:text-blue-400 hover:underline">View All</a>
                                </div>
                                <div class="space-y-4">
                                    @forelse($recentEvents as $event)
                                        <div
                                            class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-600 rounded-lg">
                                            <div>
                                                <h4 class="font-medium text-gray-900 dark:text-white">
                                                    {{ $event->name }}</h4>
                                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                                    {{ \Carbon\Carbon::parse($event->date)->format('M d, Y') }}</p>
                                            </div>
                                            <span
                                                class="px-2 py-1 text-xs rounded-full {{ $event->status === 'approved' ? 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100' : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100' }}">
                                                {{ ucfirst($event->status) }}
                                            </span>
                                        </div>
                                    @empty
                                        <p class="text-gray-500 dark:text-gray-400 p-3">No recent events</p>
                                    @endforelse
                                </div>
                            </div>

                            <!-- Recent Registrations -->
                            <div class="bg-white dark:bg-gray-700 p-6 rounded-xl shadow-sm">
                                <div class="flex items-center justify-between mb-4">
                                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">Recent Registrations
                                    </h3>
                                    <a href="{{ route('admin.registrations') }}"
                                        class="text-blue-600 dark:text-blue-400 hover:underline">View All</a>
                                </div>
                                <div class="space-y-4">
                                    @forelse($recentRegistrations as $registration)
                                        <div
                                            class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-600 rounded-lg">
                                            <div>
                                                <h4 class="font-medium text-gray-900 dark:text-white">
                                                    {{ $registration->user->name }}</h4>
                                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                                    {{ $registration->event->name }}</p>
                                            </div>
                                            <span
                                                class="px-2 py-1 text-xs rounded-full {{ $registration->status === 'confirmed' ? 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100' : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100' }}">
                                                {{ ucfirst($registration->status) }}
                                            </span>
                                        </div>
                                    @empty
                                        <p class="text-gray-500 dark:text-gray-400 p-3">No recent registrations</p>
                                    @endforelse
                                </div>
                            </div>
                        </div>

                        <!-- Management Section -->
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Quick Actions</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            <!-- Manage Users Card -->
                            <a href="{{ route('admin.users') }}"
                                class="group bg-white dark:bg-gray-700 p-6 rounded-xl shadow-sm hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors">
                                <div class="flex items-center gap-4">
                                    <div class="bg-blue-100 dark:bg-blue-800 p-3 rounded-lg">
                                        <svg class="w-6 h-6 text-blue-600 dark:text-blue-300" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="font-medium text-gray-900 dark:text-white">Manage Users</h4>
                                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">View and manage user
                                            accounts</p>
                                    </div>
                                </div>
                            </a>

                            <!-- Manage Events Card -->
                            <a href="{{ route('admin.events') }}"
                                class="group bg-white dark:bg-gray-700 p-6 rounded-xl shadow-sm hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors">
                                <div class="flex items-center gap-4">
                                    <div class="bg-green-100 dark:bg-green-800 p-3 rounded-lg">
                                        <svg class="w-6 h-6 text-green-600 dark:text-green-300" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="font-medium text-gray-900 dark:text-white">Manage Events</h4>
                                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Approve or reject
                                            pending events</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <footer class="bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div>
                        <div class="font-bold text-xl mb-4 text-gray-800 dark:text-white">EventHub</div>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">
                            Bringing people together through memorable events and experiences.
                        </p>
                    </div>
                    <div>
                        <h3 class="text-base font-semibold text-gray-800 dark:text-white mb-4">Need Help?</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                            Have questions or need assistance? Our support team is here to help you.
                        </p>
                        <button
                            class="inline-flex items-center px-4 py-2.5 text-sm font-medium text-white bg-gray-700 hover:bg-gray-600 focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600 rounded-lg transition">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
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
