@php
    use Carbon\Carbon;
    $today = Carbon::now();
    $startOfMonth = $today->copy()->startOfMonth();
    $endOfMonth = $today->copy()->endOfMonth();
    $startDayOfWeek = $startOfMonth->dayOfWeek;
    $daysInMonth = $today->daysInMonth;
@endphp

<x-app-layout>
    <div class="min-h-screen flex flex-col">
        <main class="flex-grow py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">

                <!-- Dashboard Title -->
                <div class="text-center">
                    <h1 class="text-3xl font-semibold text-gray-800 dark:text-gray-100 tracking-tight">Welcome to Your Dashboard</h1>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Your monthly overview, events, and useful resources</p>
                </div>

                <!-- Calendar Widget -->
                <div class="rounded-xl shadow-md border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700">
                        <h2 class="text-lg font-medium text-gray-800 dark:text-gray-100">📅 Your Schedule</h2>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Events and activities for {{ $today->format('F Y') }}</p>
                    </div>

                    <div class="p-6 bg-gray-50 dark:bg-gray-950">
                        <!-- Week Headers -->
                        <div class="grid grid-cols-7 text-center text-sm text-gray-500 dark:text-gray-400 font-medium mb-2">
                            @foreach(['Sun','Mon','Tue','Wed','Thu','Fri','Sat'] as $day)
                                <div class="py-1">{{ $day }}</div>
                            @endforeach
                        </div>

                        <!-- Days Grid -->
                        <div class="grid grid-cols-7 gap-1 text-xs text-center">
                            @for ($i = 0; $i < $startDayOfWeek; $i++)
                                <div class="p-2"></div>
                            @endfor

                            @for ($day = 1; $day <= $daysInMonth; $day++)
                                @php
                                    $date = Carbon::create($today->year, $today->month, $day);
                                    $isToday = $date->isToday();
                                    $eventText = $events[$date->toDateString()] ?? null;
                                @endphp

                                <div class="p-2 rounded-lg transition-all {{ $isToday ? 'bg-gray-200 dark:bg-gray-700 font-semibold text-gray-900 dark:text-white' : 'hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-700 dark:text-gray-300' }}">
                                    <div>{{ $day }}</div>
                                    @if($eventText)
                                        <div class="mt-1 text-[0.65rem] text-blue-600 dark:text-blue-400 font-medium truncate">{{ $eventText }}</div>
                                    @endif
                                </div>
                            @endfor
                        </div>
                    </div>

                    <!-- Calendar Legend -->
                    <div class="flex items-center justify-between px-6 py-4 border-t border-gray-200 dark:border-gray-700 text-xs text-gray-500 dark:text-gray-400">
                        <div class="flex space-x-4">
                            <div class="flex items-center gap-1">
                                <div class="w-3 h-3 bg-gray-300 dark:bg-gray-700 rounded-full"></div>
                                <span>Today</span>
                            </div>
                            <div class="flex items-center gap-1">
                                <div class="w-3 h-3 bg-blue-300 dark:bg-blue-600 rounded-full"></div>
                                <span>Event</span>
                            </div>
                        </div>
                        <a href="#" class="text-blue-600 dark:text-blue-400 hover:underline">View Full Calendar →</a>
                    </div>
                </div>

                <!-- Announcement Block -->
                <div class="bg-white dark:bg-gray-900 border-l-4 border-indigo-500 rounded-lg shadow-sm p-5">
                    <h3 class="text-lg font-medium text-gray-800 dark:text-gray-100 mb-1">📢 Announcements</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Stay updated with the latest news and events.</p>
                </div>

                <!-- Event Cards Section -->
                <div class="grid md:grid-cols-2 gap-6">
                    @foreach (range(1, 2) as $index)
                        <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl shadow-sm hover:shadow-md transition-shadow">
                            <div class="flex flex-col md:flex-row">
                                <div class="md:w-1/4 flex items-center justify-center bg-gray-50 dark:bg-gray-800 p-4">
                                    <span class="text-2xl font-bold text-indigo-500">Event</span>
                                </div>
                                <div class="md:w-3/4 p-5 space-y-2">
                                    <h4 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Sample Event Title {{ $index }}</h4>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Category: <span class="text-indigo-600 dark:text-indigo-400">Schedule Update</span></p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Organizer: John Doe</p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Date: 21/03/2025</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
        </main>

        <!-- Sticky Footer -->
        <footer class="bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 shadow-sm">
            <div class="max-w-7xl mx-auto px-6 py-8 grid grid-cols-1 md:grid-cols-2 gap-6 text-sm">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-3">Resources</h3>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                        <a href="#" class="text-gray-600 dark:text-gray-400 hover:underline">FAQ</a>
                        <a href="#" class="text-gray-600 dark:text-gray-400 hover:underline">Help Center</a>
                        <a href="#" class="text-gray-600 dark:text-gray-400 hover:underline">User Guide</a>
                        <a href="#" class="text-gray-600 dark:text-gray-400 hover:underline">Terms</a>
                        <a href="#" class="text-gray-600 dark:text-gray-400 hover:underline">Privacy</a>
                        <a href="#" class="text-gray-600 dark:text-gray-400 hover:underline">Contact</a>
                    </div>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-3">Need Help?</h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-3">Have questions or need assistance? We’re here for you.</p>
                    <button class="inline-block px-4 py-2 text-sm font-medium text-gray-700 dark:text-white bg-gray-100 dark:bg-gray-700 rounded hover:bg-gray-200 dark:hover:bg-gray-600 transition">
                        Contact Support
                    </button>
                </div>
            </div>
        </footer>
    </div>
</x-app-layout>
