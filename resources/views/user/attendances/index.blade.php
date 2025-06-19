<x-app-layout>
    <div
        class="flex flex-col min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800">
        <main class="flex-grow py-6 sm:py-8 md:py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 shadow-lg sm:rounded-xl overflow-hidden">
                    <div class="relative bg-unimasblue dark:bg-unimasblue p-6">
                        <div class="absolute inset-0 opacity-10 bg-pattern-grid"></div>
                        <h1 class="text-2xl sm:text-3xl font-bold text-center text-white">
                            My Event Attendance History
                        </h1>
                    </div>

                    <div class="p-4 sm:p-6 md:p-8">
                        @if ($attendances->isEmpty())
                            <div class="flex flex-col items-center justify-center py-12 text-center">
                                <div class="text-gray-400 dark:text-gray-500 mb-4">
                                    <svg class="h-16 w-16 mx-auto" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                </div>
                                <p class="text-gray-600 dark:text-gray-300 text-lg font-medium mb-2">
                                    No attended events yet
                                </p>
                                <p class="text-gray-500 dark:text-gray-400 mb-6">
                                    Your attended events will appear here once you've participated in them.
                                </p>
                            </div>
                        @else
                            <div class="grid gap-6 md:gap-8">
                                @foreach ($attendances as $attendance)
                                    <div
                                        class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl shadow-sm hover:shadow-md transition-shadow duration-300">
                                        <div class="p-6">
                                            <div class="flex flex-col lg:flex-row">
                                                <div class="flex-1">
                                                    <div class="flex justify-between items-start mb-4">
                                                        <div class="flex-1 pr-4">
                                                            <h3
                                                                class="text-lg font-semibold text-gray-900 dark:text-white mb-1">
                                                                {{ $attendance->eventRegistration->event->name }}
                                                            </h3>
                                                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                                                {{ $attendance->eventRegistration->event->location }}
                                                            </p>
                                                        </div>
                                                        <div class="w-24 flex-shrink-0">
                                                            <span
                                                                class="px-3 py-1 inline-flex justify-center w-full text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100">
                                                                Attended
                                                            </span>
                                                        </div>
                                                    </div>

                                                    <div
                                                        class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 text-sm">
                                                        <div>
                                                            <span
                                                                class="block text-gray-500 dark:text-gray-400 font-medium">Event
                                                                Date</span>
                                                            <span class="text-gray-900 dark:text-white">
                                                                {{ \Carbon\Carbon::parse($attendance->eventRegistration->event->date)->format('d M Y, h:i A') }}
                                                            </span>
                                                        </div>
                                                        <div>
                                                            <span
                                                                class="block text-gray-500 dark:text-gray-400 font-medium">Attended
                                                                At</span>
                                                            <span class="text-gray-900 dark:text-white">
                                                                {{ \Carbon\Carbon::parse($attendance->attended_at)->format('d M Y, h:i A') }}
                                                            </span>
                                                        </div>
                                                        <div>
                                                            <span
                                                                class="block text-gray-500 dark:text-gray-400 font-medium">Ticket
                                                                Type</span>
                                                            <span class="text-gray-900 dark:text-white">
                                                                {{ $attendance->eventRegistration->ticket->type }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
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
