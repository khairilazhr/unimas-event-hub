<!-- resources/views/admin/admin-dashboard.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats Overview -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="text-lg font-medium mb-2">Total Users</h3>
                        <p class="text-3xl font-bold">{{ $userCount }}</p>
                        <div class="mt-2 flex items-center text-sm">
                            <span class="text-gray-500 dark:text-gray-400">{{ $organizerCount }} Organizers</span>
                            <span class="mx-2">|</span>
                            <span class="text-gray-500 dark:text-gray-400">{{ $regularUserCount }} Regular Users</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="text-lg font-medium mb-2">Total Events</h3>
                        <p class="text-3xl font-bold">{{ $eventCount }}</p>
                        <div class="mt-2 flex items-center text-sm">
                            <span class="text-gray-500 dark:text-gray-400">{{ $activeEventCount }} Active</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="text-lg font-medium mb-2">Total Registrations</h3>
                        <p class="text-3xl font-bold">{{ $registrationCount }}</p>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="text-lg font-medium mb-2">Forum Activity</h3>
                        <p class="text-3xl font-bold">{{ $forumTopicCount }}</p>
                        <div class="mt-2 flex items-center text-sm">
                            <span class="text-gray-500 dark:text-gray-400">{{ $forumReplyCount }} Replies</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Access Panels -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <!-- Recent Events -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Recent Events</h3>
                            <a>View All</a>

                        </div>
                        <div class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($recentEvents as $event)
                                <div class="py-3">
                                    <div class="flex justify-between">
                                        <div>
                                            <h4 class="font-medium text-gray-900 dark:text-gray-100">{{ $event->name }}</h4>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $event->date }}</p>
                                        </div>
                                        <span class="px-2 py-1 text-xs rounded-full {{ $event->status === 'active' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200' }}">
                                            {{ ucfirst($event->status) }}
                                        </span>
                                    </div>
                                </div>
                            @empty
                                <p class="text-gray-500 dark:text-gray-400">No events found</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Recent Registrations -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Recent Registrations</h3>
                            <a>View All</a>
                        </div>
                        <div class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($recentRegistrations as $registration)
                                <div class="py-3">
                                    <div class="flex justify-between">
                                        <div>
                                            <h4 class="font-medium text-gray-900 dark:text-gray-100">{{ $registration->name }}</h4>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                                {{ $registration->event->name }}
                                            </p>
                                        </div>
                                        <span class="px-2 py-1 text-xs rounded-full {{ $registration->status === 'confirmed' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200' }}">
                                            {{ ucfirst($registration->status) }}
                                        </span>
                                    </div>
                                </div>
                            @empty
                                <p class="text-gray-500 dark:text-gray-400">No recent registrations</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- Management Section -->
            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Management</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <a class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 flex items-center hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                    <div class="bg-blue-100 dark:bg-blue-900 p-3 rounded-full mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600 dark:text-blue-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-medium text-gray-900 dark:text-gray-100">Manage Users</h4>
                        <p class="text-sm text-gray-500 dark:text-gray-400">View, edit, and manage user accounts</p>
                    </div>
                </a>

                <a class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 flex items-center hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                    <div class="bg-green-100 dark:bg-green-900 p-3 rounded-full mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600 dark:text-green-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-medium text-gray-900 dark:text-gray-100">Manage Events</h4>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Create, edit, and manage events</p>
                    </div>
                </a>

                <a  class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 flex items-center hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                    <div class="bg-purple-100 dark:bg-purple-900 p-3 rounded-full mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-600 dark:text-purple-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-medium text-gray-900 dark:text-gray-100">Manage Tickets</h4>
                        <p class="text-sm text-gray-500 dark:text-gray-400">View and manage ticket inventory</p>
                    </div>
                </a>

                <a  class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 flex items-center hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                    <div class="bg-yellow-100 dark:bg-yellow-900 p-3 rounded-full mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-600 dark:text-yellow-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-medium text-gray-900 dark:text-gray-100">Manage Registrations</h4>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Review and manage event registrations</p>
                    </div>
                </a>

                <a class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 flex items-center hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                    <div class="bg-red-100 dark:bg-red-900 p-3 rounded-full mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600 dark:text-red-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-medium text-gray-900 dark:text-gray-100">Manage Forum</h4>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Moderate topics and replies</p>
                    </div>
                </a>

                <a class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 flex items-center hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                    <div class="bg-indigo-100 dark:bg-indigo-900 p-3 rounded-full mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600 dark:text-indigo-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-medium text-gray-900 dark:text-gray-100">Manage Announcements</h4>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Create and manage announcements</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
