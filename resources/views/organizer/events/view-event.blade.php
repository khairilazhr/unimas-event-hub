<x-app-layout>
    <div class="min-h-screen flex flex-col">
        <main class="flex-grow py-6 sm:py-8 md:py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="mb-6">
                    <a href="{{ route('organizer.events') }}" class="inline-flex items-center text-sm text-gray-600 dark:text-gray-400 hover:text-unimasblue dark:hover:text-unimasblue transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                        Back to My Events
                    </a>
                </div>

                <div class="bg-white dark:bg-gray-800 shadow-lg sm:rounded-xl overflow-hidden">
                    <div class="relative bg-unimasblue dark:bg-unimasblue p-6">
                        <div class="absolute inset-0 opacity-10 bg-pattern-grid"></div>
                        <h1 class="text-2xl sm:text-3xl font-bold text-center text-white">
                            Event Details
                        </h1>
                    </div>

                    <div class="p-4 sm:p-6 md:p-8 space-y-6">
                        <!-- Status Badge -->
                        <div class="flex items-center">
                            <span class="px-3 py-1.5 text-sm font-semibold rounded-full
                                @if($event->status == 'approved')
                                    bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100
                                @elseif($event->status == 'pending')
                                    bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100
                                @elseif($event->status == 'cancelled')
                                    bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100
                                @else
                                    bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-100
                                @endif
                            ">
                                {{ ucfirst($event->status ?? 'unknown') }}
                            </span>
                        </div>

                        <!-- Event Name -->
<div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 shadow-sm">
                            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $event->name }}</h2>
                        </div>

                        <!-- Event Description -->
<div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 shadow-sm">
                            <h3 class="text-lg font-medium text-gray-700 dark:text-gray-300 mb-2">Description</h3>
                            <p class="text-gray-600 dark:text-gray-400">{{ $event->description }}</p>
                        </div>

                        <!-- Event Date & Location -->
<div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 shadow-sm">
    <div class="flex"> <div>
            <h3 class="text-lg font-medium text-gray-700 dark:text-gray-300 mb-2">Date & Time</h3>
            <div class="flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 dark:text-gray-400 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <p class="text-gray-600 dark:text-gray-400">
                    {{ $event->date ? \Carbon\Carbon::parse($event->date)->format('F j, Y \a\t g:i A') : 'Date not specified' }}
                </p>
            </div>
        </div>
        <div class="ml-4"> <h3 class="text-lg font-medium text-gray-700 dark:text-gray-300 mb-2">Location</h3>
            <div class="flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 dark:text-gray-400 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <p class="text-gray-600 dark:text-gray-400">{{ $event->location ?? 'Location not specified' }}</p>
            </div>
        </div>
    </div>
</div>

                        <!-- Event Statistics -->
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 shadow-sm">
                            <h3 class="text-lg font-medium text-gray-700 dark:text-gray-300 mb-4">Event Statistics</h3>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Total Registrations</p>
                                    <p class="text-xl font-bold text-gray-900 dark:text-white">{{ $event->registrations_count ?? 0 }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Created On</p>
                                    <p class="text-gray-700 dark:text-gray-300">{{ $event->created_at->format('F j, Y') }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Last Updated</p>
                                    <p class="text-gray-700 dark:text-gray-300">{{ $event->updated_at->format('F j, Y') }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Tickets Section -->
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 shadow-sm">
                                                        <h3 class="text-lg font-medium text-gray-700 dark:text-gray-300 mb-4">Tickets</h3>

@php
    $groupedTickets = $event->tickets->groupBy('type');
@endphp

@if($groupedTickets->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach($groupedTickets as $type => $tickets)
            @php
                $sample = $tickets->first();
                $totalSeats = $tickets->filter(function($ticket) {
                    return $ticket->section || $ticket->row || $ticket->seat;
                })->count();
            @endphp
            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 border border-gray-200 dark:border-gray-600 hover:shadow-md transition-shadow">
                <div class="flex justify-between items-start mb-2">
                    <h4 class="font-medium text-gray-900 dark:text-white">{{ $type }}</h4>
                    <span class="text-sm font-bold text-gray-900 dark:text-white">RM {{ number_format($sample->price, 2) }}</span>
                </div>
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-2 line-clamp-2">{{ $sample->description }}</p>
                <div class="text-xs text-gray-500 dark:text-gray-400 mt-3 pt-2 border-t border-gray-200 dark:border-gray-600">
                    Number of seats: {{ $totalSeats }}
                </div>
            </div>
        @endforeach
    </div>
@else
    <div class="rounded-lg border border-gray-200 dark:border-gray-700 p-6 bg-gray-50 dark:bg-gray-700 text-center">
        <div class="text-gray-400 dark:text-gray-500 mb-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-6h6v6h4v-8h-4V7a2 2 0 00-2-2H7v4h2v6H5v4h4z" />
            </svg>
        </div>
        <p class="text-sm text-gray-600 dark:text-gray-400">No tickets available yet.</p>
    </div>
@endif
                        </div>

                                                <!-- Action Buttons -->
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 shadow-sm">
                            <h3 class="text-lg font-medium text-gray-700 dark:text-gray-300 mb-4">Actions</h3>
                            <div class="space-y-3">
                                @if($event->status == 'approved')
                                    <a href="{{ route('organizer.edit.event', $event->id) }}"
                                       class="w-full flex items-center justify-center px-4 py-2.5 bg-unimasblue hover:bg-unimasblue text-white text-sm font-medium rounded-lg transition duration-300 shadow-md hover:shadow-lg">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                        Edit Event
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</x-app-layout>
