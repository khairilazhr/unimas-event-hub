@php
    use Carbon\Carbon;

    $today = Carbon::now();
    $startOfMonth = Carbon::now()->startOfMonth();
    $endOfMonth = Carbon::now()->endOfMonth();
    $startDayOfWeek = $startOfMonth->dayOfWeek; // 0 = Sunday, 6 = Saturday
    $daysInMonth = $today->daysInMonth;
@endphp

<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h1 class="text-2xl font-light text-center mb-10">Dashboard</h1>

                    <!-- Interactive Calendar Widget -->
                    <div class="mb-10 border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden">
                        <div class="bg-white dark:bg-gray-800 p-4 border-b border-gray-200 dark:border-gray-700">
                            <h2 class="text-lg font-medium">Your Schedule</h2>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Events and bookings for this month</p>
                        </div>
                        <div class="p-4 bg-gray-50 dark:bg-gray-900">
                            <!-- Week Days Header -->
                            <div class="grid grid-cols-7 gap-1 mb-2">
                                @foreach(['Sun','Mon','Tue','Wed','Thu','Fri','Sat'] as $day)
                                    <div class="text-center text-xs text-gray-500 dark:text-gray-400 font-medium py-1">
                                        {{ $day }}
                                    </div>
                                @endforeach
                            </div>

                            <!-- Calendar Grid -->
                            <div class="grid grid-cols-7 gap-1 text-center text-xs">
                                {{-- Empty cells before first day --}}
                                @for($i = 0; $i < $startDayOfWeek; $i++)
                                    <div class="p-1 text-gray-400 dark:text-gray-600"></div>
                                @endfor

                                {{-- Loop through days in month --}}
                                @for($day = 1; $day <= $daysInMonth; $day++)
                                    @php
                                        $date = Carbon::create($today->year, $today->month, $day);
                                        $isToday = $date->isToday();
                                        $eventText = $events[$date->toDateString()] ?? null;
                                    @endphp

                                    <div class="p-2 rounded-lg {{ $isToday ? 'bg-gray-200 dark:bg-gray-700 font-bold' : 'hover:bg-gray-100 dark:hover:bg-gray-800' }}">
                                        <div>{{ $day }}</div>
                                        @if($eventText)
                                            <div class="text-xs text-blue-600 dark:text-blue-400 font-medium mt-1">{{ $eventText }}</div>
                                        @endif
                                    </div>
                                @endfor
                            </div>
                        </div>

                        <!-- Legend and Full View Link -->
                        <div class="p-4 border-t border-gray-200 dark:border-gray-700 flex justify-between items-center">
                            <div class="flex space-x-2">
                                <div class="flex items-center space-x-1">
                                    <div class="w-3 h-3 bg-gray-200 dark:bg-gray-700 rounded-full"></div>
                                    <span class="text-xs text-gray-500 dark:text-gray-400">Today</span>
                                </div>
                                <div class="flex items-center space-x-1">
                                    <div class="w-3 h-3 bg-blue-200 dark:bg-blue-700 rounded-full"></div>
                                    <span class="text-xs text-gray-500 dark:text-gray-400">Event</span>
                                </div>
                            </div>
                            <button class="text-xs text-blue-600 dark:text-blue-400 hover:underline">View Full Calendar</button>
                        </div>
                    </div>

                    <!-- Event Announcement -->
                    <div class="bg-white dark:bg-gray-800 border-l-4 border-gray-400 dark:border-gray-600 mb-8 p-4">
                        <h2 class="text-lg font-medium mb-1">Event Announcement</h2>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Check our latest updates and upcoming events
                        </p>
                    </div>

                    <!-- Event Cards -->
                    <div class="space-y-6">
                        <!-- Event Card 1 -->
                        <div
                            class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden">
                            <div class="md:flex">
                                <div class="md:w-1/4 p-4 flex items-center justify-center bg-gray-50 dark:bg-gray-900">
                                    <div class="text-center">
                                        <span
                                            class="block text-xl font-light text-gray-500 dark:text-gray-400">EVENT</span>
                                    </div>
                                </div>
                                <div class="md:w-2/3 p-6">
                                    <h3 class="text-lg font-medium mb-2">Event Name</h3>
                                    <div class="space-y-1 text-sm">
                                        <p class="text-gray-500 dark:text-gray-400">Schedule Update</p>
                                        <p class="text-gray-500 dark:text-gray-400">By: Organizer Name</p>
                                        <p class="text-gray-500 dark:text-gray-400">Date: dd/mm/yyy</p>
                                    </div>
                                </div>
                                <div class="md:w-1/12 flex items-center justify-center p-4">
                                    <button
                                        class="p-2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5l7 7-7 7" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Event Card 2 -->
                        <div
                            class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden">
                            <div class="md:flex">
                                <div class="md:w-1/4 p-4 flex items-center justify-center bg-gray-50 dark:bg-gray-900">
                                    <div class="text-center">
                                        <span
                                            class="block text-xl font-light text-gray-500 dark:text-gray-400">EVENT</span>
                                    </div>
                                </div>
                                <div class="md:w-2/3 p-6">
                                    <h3 class="text-lg font-medium mb-2">Event Name</h3>
                                    <div class="space-y-1 text-sm">
                                        <p class="text-gray-500 dark:text-gray-400">Schedule Update</p>
                                        <p class="text-gray-500 dark:text-gray-400">By: Organizer Name</p>
                                        <p class="text-gray-500 dark:text-gray-400">Date: dd/mm/yyy</p>
                                    </div>
                                </div>
                                <div class="md:w-1/12 flex items-center justify-center p-4">
                                    <button
                                        class="p-2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5l7 7-7 7" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Resource Links Footer -->
            <div class="mt-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-t border-gray-200 dark:border-gray-700">
                    <div class="md:flex justify-between">
                        <div class="mb-6 md:mb-0">
                            <h3 class="text-sm font-medium text-gray-900 dark:text-gray-100 mb-2">Resources</h3>
                            <div class="grid grid-cols-2 gap-2 md:grid-cols-3 md:gap-4">
                                <a href="#"
                                    class="text-sm text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300">FAQ</a>
                                <a href="#"
                                    class="text-sm text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300">Help
                                    Center</a>
                                <a href="#"
                                    class="text-sm text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300">User
                                    Guide</a>
                                <a href="#"
                                    class="text-sm text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300">Terms
                                    of Service</a>
                                <a href="#"
                                    class="text-sm text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300">Privacy
                                    Policy</a>
                                <a href="#"
                                    class="text-sm text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300">Contact
                                    Support</a>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-900 dark:text-gray-100 mb-2">Need Help?</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">Have questions or need assistance?
                            </p>
                            <button
                                class="text-sm bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 px-4 py-2 rounded-md hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">Contact
                                Support</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>