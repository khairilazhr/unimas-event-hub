<x-app-layout>
    <div class="min-h-screen flex flex-col">
        <!-- Main Content -->
        <main class="container mx-auto px-4 py-8 flex-1">
            <div class="space-y-6">
                <!-- Welcome Header -->
                <div class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-6">
                    Welcome, {{ Auth::user()->name }}!
                </div>

                <!-- Dashboard Content -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Dashboard Overview -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-4">
                        <div class="flex justify-between items-center mb-3">
                            <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100">
                                Dashboard Overview
                            </h2>
                            <form action="{{ route('organizer.dashboard.report') }}" method="GET" target="_blank">
                                <button type="submit"
                                    class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-white bg-unimasblue hover:bg-blue-700 rounded transition">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    Download Report
                                </button>
                            </form>
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <div class="bg-gray-100 dark:bg-gray-700 rounded-lg p-3 text-center">
                                <div class="text-gray-600 dark:text-gray-400 text-xs">Total Events</div>
                                <div class="text-xl font-bold text-gray-800 dark:text-gray-100">
                                    {{ $totalEvents }}
                                </div>
                            </div>
                            <div class="bg-gray-100 dark:bg-gray-700 rounded-lg p-3 text-center">
                                <div class="text-gray-600 dark:text-gray-400 text-xs">Upcoming</div>
                                <div class="text-xl font-bold text-gray-800 dark:text-gray-100">
                                    {{ $upcomingEvents }}
                                </div>
                            </div>
                            <div class="bg-gray-100 dark:bg-gray-700 rounded-lg p-3 text-center">
                                <div class="text-gray-600 dark:text-gray-400 text-xs">Pending</div>
                                <div class="text-xl font-bold text-gray-800 dark:text-gray-100">
                                    {{ $pendingPayments }}
                                </div>
                            </div>
                            <div class="bg-gray-100 dark:bg-gray-700 rounded-lg p-3 text-center">
                                <div class="text-gray-600 dark:text-gray-400 text-xs">Participants</div>
                                <div class="text-xl font-bold text-gray-800 dark:text-gray-100">
                                    {{ $totalParticipants }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- My Events Panel -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-4">
                        <div class="flex justify-between items-center mb-3">
                            <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100">
                                My Events
                            </h2>
                            <a href="#" class="text-xs text-blue-600 hover:text-blue-800 dark:text-blue-400">
                                View All
                            </a>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-xs">
                                <thead class="bg-gray-100 dark:bg-gray-700">
                                    <tr>
                                        <th class="px-2 py-1.5">Event</th>
                                        <th class="px-2 py-1.5">Date</th>
                                        <th class="px-2 py-1.5">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($events->take(4) as $event)
                                        <tr class="border-b dark:border-gray-700">
                                            <td class="px-2 py-1.5">{{ Str::limit($event->name, 20) }}</td>
                                            <td class="px-2 py-1.5">
                                                {{ \Carbon\Carbon::parse($event->date)->format('d/m/Y') }}
                                            </td>
                                            <td class="px-2 py-1.5">
                                                @php
                                                    $statusColor = match ($event->status) {
                                                        'pending' => 'text-yellow-500',
                                                        'approved' => 'text-green-600',
                                                        'rejected' => 'text-red-600',
                                                        default => 'text-gray-500',
                                                    };
                                                @endphp
                                                <span class="{{ $statusColor }} capitalize">
                                                    {{ $event->status }}
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center py-2 text-gray-500">
                                                No events found
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Announcements -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-4">
                        <div class="flex justify-between items-center mb-3">
                            <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100">
                                Announcements
                            </h2>
                            <a href="{{ route('announcements.index') }}"
                                class="text-xs text-blue-600 hover:text-blue-800">
                                New
                            </a>
                        </div>
                        <div class="bg-gray-100 dark:bg-gray-700 rounded-lg p-3 max-h-[200px] overflow-y-auto">
                            <h3 class="text-xs font-semibold text-gray-700 dark:text-gray-200 mb-2">Recent:</h3>
                            <ul class="space-y-2">
                                <li class="text-xs text-gray-600 dark:text-gray-400">
                                    - Schedule Change for Event 1
                                </li>
                                <li class="text-xs text-gray-600 dark:text-gray-400">
                                    - New Event Coming Soon
                                </li>
                            </ul>
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
