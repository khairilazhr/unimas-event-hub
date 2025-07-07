<x-app-layout>
    <div
        class="flex flex-col min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800">
        {{-- Main Content --}}
        <main class="flex-grow py-6 sm:py-8 md:py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 shadow-lg sm:rounded-xl overflow-hidden">
                    <div class="relative bg-unimasblue dark:bg-unimasblue p-6">
                        <div class="absolute inset-0 opacity-10 bg-pattern-grid"></div>
                        <h1 class="text-2xl sm:text-3xl font-bold text-center text-white">
                            My Bookings
                        </h1>
                    </div>

                    <div class="p-4 sm:p-6 md:p-8">
                        @if ($registrations->isEmpty())
                            <div class="flex flex-col items-center justify-center py-12 text-center">
                                <div class="text-gray-400 dark:text-gray-500 mb-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                </div>
                                <p class="text-gray-600 dark:text-gray-300 text-lg font-medium mb-2">
                                    You don't have any bookings yet
                                </p>
                                <p class="text-gray-500 dark:text-gray-400 mb-6">
                                    Find exciting events and reserve your tickets now!
                                </p>
                                <a href="{{ route('user.events') }}"
                                    class="inline-flex items-center px-5 py-2.5 bg-unimasblue hover:bg-unimasblue text-white text-sm font-medium rounded-lg transition duration-300 shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                                    <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                    Browse Events
                                </a>
                            </div>
                        @else
                            @php
                                $userEmail = Auth::user()->email;
                                $ownRegistrations = $registrations->filter(function ($registration) use ($userEmail) {
                                    return $registration->email === $userEmail;
                                });
                                $otherRegistrations = $registrations->filter(function ($registration) use ($userEmail) {
                                    return $registration->email !== $userEmail;
                                });
                            @endphp
                            <div class="grid gap-6 md:gap-8">
                                @foreach ($ownRegistrations as $registration)
                                    <div
                                        class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl shadow-sm hover:shadow-md transition-shadow duration-300">
                                        <div class="p-6">
                                            <!-- Top Section with Fixed Height -->
                                            <div class="flex flex-col lg:flex-row min-h-[120px]">
                                                <!-- Left Content -->
                                                <div class="flex-1">
                                                    <!-- Header with Fixed Status Position -->
                                                    <div class="flex justify-between items-start mb-4">
                                                        <div class="flex-1 pr-4">
                                                            <h3
                                                                class="text-lg font-semibold text-gray-900 dark:text-white mb-1 truncate">
                                                                {{ $registration->event->name }}
                                                            </h3>
                                                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                                                {{ $registration->event->location }}
                                                            </p>
                                                        </div>
                                                        <!-- Fixed Width Status Badge -->
                                                        <div class="w-24 flex-shrink-0">
                                                            <span
                                                                class="px-3 py-1 inline-flex justify-center w-full text-xs leading-5 font-semibold rounded-full
                                                        @if ($registration->status == 'approved') bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100
                                                        @elseif($registration->status == 'pending')
                                                            bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100
                                                        @elseif($registration->status == 'rejected')
                                                            bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100
                                                        @else
                                                            bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-100 @endif">
                                                                {{ ucfirst($registration->status ?? 'unknown') }}
                                                            </span>
                                                        </div>
                                                    </div>

                                                    <!-- Event Details Grid -->
                                                    <div
                                                        class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                                                        <div>
                                                            <span
                                                                class="block text-gray-500 dark:text-gray-400 font-medium">Date
                                                                & Time</span>
                                                            <span class="text-gray-900 dark:text-white">
                                                                {{ \Carbon\Carbon::parse($registration->event->date)->format('d M Y') }}
                                                            </span>
                                                            <span
                                                                class="block text-gray-600 dark:text-gray-300 text-xs">
                                                                {{ \Carbon\Carbon::parse($registration->event->date)->format('h:i A') }}
                                                            </span>
                                                        </div>
                                                        <div>
                                                            <span
                                                                class="block text-gray-500 dark:text-gray-400 font-medium">Ticket
                                                                Type</span>
                                                            <span class="text-gray-900 dark:text-white">
                                                                {{ $registration->ticket->type }}
                                                            </span>
                                                        </div>
                                                        <div>
                                                            <span
                                                                class="block text-gray-500 dark:text-gray-400 font-medium">Seat</span>
                                                            <span class="text-gray-900 dark:text-white">
                                                                {{ $registration->ticket->section }} - Row
                                                                {{ $registration->ticket->row }} - Seat
                                                                {{ $registration->ticket->seat }}
                                                            </span>
                                                        </div>
                                                        <div>
                                                            <span
                                                                class="block text-gray-500 dark:text-gray-400 font-medium">Price</span>
                                                            <span class="text-gray-900 dark:text-white font-semibold">
                                                                RM{{ number_format($registration->ticket->price, 2) }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Right Content - Fixed Width Actions Column -->
                                                <div class="lg:w-48 flex-shrink-0 lg:ml-6 mt-4 lg:mt-0">
                                                    <div class="flex flex-col gap-1.5">
                                                        <a href="{{ route('user.events.registration-details', $registration->id) }}"
                                                            class="inline-flex items-center justify-center w-full px-2 py-1.5 text-xs font-medium rounded border border-blue-200 bg-blue-50 text-blue-700 hover:bg-blue-100 dark:bg-blue-900/20 dark:text-blue-300 dark:border-blue-700 dark:hover:bg-blue-900/30 transition-colors">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1"
                                                                fill="none" viewBox="0 0 24 24"
                                                                stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                            </svg>
                                                            View Details
                                                        </a>

                                                        @if ($registration->status == 'approved')
                                                            <a href="{{ route('forum.index', ['eventId' => $registration->event->id]) }}"
                                                                class="inline-flex items-center justify-center w-full px-2 py-1.5 text-xs font-medium rounded border border-purple-200 bg-purple-50 text-purple-700 hover:bg-purple-100 dark:bg-purple-900/20 dark:text-purple-300 dark:border-purple-700 dark:hover:bg-purple-900/30 transition-colors">
                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                    class="h-3 w-3 mr-1" fill="none"
                                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2"
                                                                        d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                                                                </svg>
                                                                Forum
                                                            </a>

                                                            <a href="{{ route('user.questionnaires.index', $registration->event->id) }}"
                                                                class="inline-flex items-center justify-center w-full px-2 py-1.5 text-xs font-medium rounded border border-green-200 bg-green-50 text-green-700 hover:bg-green-100 dark:bg-green-900/20 dark:text-green-300 dark:border-green-700 dark:hover:bg-green-900/30 transition-colors">
                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                    class="h-3 w-3 mr-1" fill="none"
                                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2"
                                                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                                                </svg>
                                                                Questionnaires
                                                            </a>

                                                            @php
                                                                $event = $registration->event;
                                                                $now = \Carbon\Carbon::now();
                                                                $eventDate = \Carbon\Carbon::parse($event->date);
                                                                $refundAllowed = false;

                                                                // Only allow if refund policy is set and percentage > 0
                                                                if (
    $event->refund_window_type &&
    $event->refund_window_days &&
    $event->refund_percentage > 0
) {
    if ($event->refund_window_type === 'before') {
        // Refund allowed only if today is more than X days before event
        $refundStart = $eventDate->copy()->subDays($event->refund_window_days);
        $refundAllowed = $now->greaterThanOrEqualTo($refundStart) && $now->lessThanOrEqualTo($eventDate);
    } elseif ($event->refund_window_type === 'after') {
        // Refund allowed X days after event
        $refundDeadline = $eventDate->copy()->addDays($event->refund_window_days);
        $refundAllowed =
            $now->greaterThanOrEqualTo($eventDate) &&
            $now->lessThanOrEqualTo($refundDeadline);
    }
}
                                                                $refund =
                                                                    $registration->ticket->refunds->first() ?? null;
                                                            @endphp

                                                            @if ($refundAllowed)
                                                                @if ($refund)
                                                                    <div
                                                                        class="inline-flex flex-col items-start px-2 py-1.5 text-xs rounded border border-orange-200 bg-orange-50 dark:bg-orange-900/20 dark:border-orange-700 w-full">
                                                                        <span
                                                                            class="font-semibold text-orange-600 dark:text-orange-400">Refund
                                                                            Requested</span>
                                                                        <span
                                                                            class="text-gray-700 dark:text-gray-200">Status:
                                                                            <span class="font-bold">
                                                                                {{ ucfirst($refund->status) }}
                                                                            </span>
                                                                        </span>
                                                                    </div>
                                                                @else
                                                                    <a href="{{ route('user.refunds.index', ['ticket_id' => $registration->ticket_id]) }}"
                                                                        class="inline-flex items-center justify-center w-full px-2 py-1.5 text-xs font-medium rounded border border-orange-200 bg-orange-50 text-orange-700 hover:bg-orange-100 dark:bg-orange-900/20 dark:text-orange-300 dark:border-orange-700 dark:hover:bg-orange-900/30 transition-colors">
                                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                                            class="h-3 w-3 mr-1" fill="none"
                                                                            viewBox="0 0 24 24" stroke="currentColor">
                                                                            <path stroke-linecap="round"
                                                                                stroke-linejoin="round" stroke-width="2"
                                                                                d="M16 15v-1a4 4 0 00-4-4H8m0 0l3 3m-3-3l3-3m9 14V5a2 2 0 00-2-2H6a2 2 0 00-2 2v16l4-2 4 2 4-2 4 2z" />
                                                                        </svg>
                                                                        Request Refund
                                                                    </a>
                                                                @endif
                                                            @elseif ($event->refund_window_type && $event->refund_window_days && $event->refund_percentage > 0)
                                                                <div class="text-xs text-gray-500 dark:text-gray-400">
                                                                    Refund not available at this time based on event
                                                                    policy.</div>
                                                            @endif
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            @if ($otherRegistrations->count())
                                <div class="mt-12">
                                    <h2 class="text-xl font-bold text-gray-800 dark:text-white mb-4">Tickets Bought for
                                        Others</h2>
                                    <div class="grid gap-6 md:gap-8">
                                        @foreach ($otherRegistrations as $registration)
                                            <div
                                                class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl shadow-sm hover:shadow-md transition-shadow duration-300">
                                                <div class="p-6">
                                                    <div class="flex flex-col lg:flex-row min-h-[120px]">
                                                        <div class="flex-1">
                                                            <div class="flex justify-between items-start mb-4">
                                                                <div class="flex-1 pr-4">
                                                                    <h3
                                                                        class="text-lg font-semibold text-gray-900 dark:text-white mb-1 truncate">
                                                                        {{ $registration->event->name }}
                                                                    </h3>
                                                                    <p
                                                                        class="text-sm text-gray-600 dark:text-gray-400">
                                                                        {{ $registration->event->location }}
                                                                    </p>
                                                                    <p
                                                                        class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                                                        <span class="font-semibold">For:</span>
                                                                        {{ $registration->name }}
                                                                        ({{ $registration->email }})
                                                                    </p>
                                                                </div>
                                                                <div class="w-24 flex-shrink-0">
                                                                    <span
                                                                        class="px-3 py-1 inline-flex justify-center w-full text-xs leading-5 font-semibold rounded-full
                                                                        @if ($registration->status == 'approved') bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100
                                                                        @elseif($registration->status == 'pending')
                                                                            bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100
                                                                        @elseif($registration->status == 'rejected')
                                                                            bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100
                                                                        @else
                                                                            bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-100 @endif">
                                                                        {{ ucfirst($registration->status ?? 'unknown') }}
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <div
                                                                class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                                                                <div>
                                                                    <span
                                                                        class="block text-gray-500 dark:text-gray-400 font-medium">Date
                                                                        & Time</span>
                                                                    <span class="text-gray-900 dark:text-white">
                                                                        {{ \Carbon\Carbon::parse($registration->event->date)->format('d M Y') }}
                                                                    </span>
                                                                    <span
                                                                        class="block text-gray-600 dark:text-gray-300 text-xs">
                                                                        {{ \Carbon\Carbon::parse($registration->event->date)->format('h:i A') }}
                                                                    </span>
                                                                </div>
                                                                <div>
                                                                    <span
                                                                        class="block text-gray-500 dark:text-gray-400 font-medium">Ticket
                                                                        Type</span>
                                                                    <span class="text-gray-900 dark:text-white">
                                                                        {{ $registration->ticket->type }}
                                                                    </span>
                                                                </div>
                                                                <div>
                                                                    <span
                                                                        class="block text-gray-500 dark:text-gray-400 font-medium">Seat</span>
                                                                    <span class="text-gray-900 dark:text-white">
                                                                        {{ $registration->ticket->section }} - Row
                                                                        {{ $registration->ticket->row }} - Seat
                                                                        {{ $registration->ticket->seat }}
                                                                    </span>
                                                                </div>
                                                                <div>
                                                                    <span
                                                                        class="block text-gray-500 dark:text-gray-400 font-medium">Price</span>
                                                                    <span
                                                                        class="text-gray-900 dark:text-white font-semibold">
                                                                        RM{{ number_format($registration->ticket->price, 2) }}
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="lg:w-48 flex-shrink-0 lg:ml-6 mt-4 lg:mt-0">
                                                            <div class="flex flex-col gap-1.5">
                                                                <a href="{{ route('user.events.registration-details', $registration->id) }}"
                                                                    class="inline-flex items-center justify-center w-full px-2 py-1.5 text-xs font-medium rounded border border-blue-200 bg-blue-50 text-blue-700 hover:bg-blue-100 dark:bg-blue-900/20 dark:text-blue-300 dark:border-blue-700 dark:hover:bg-blue-900/30 transition-colors">
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                        class="h-3 w-3 mr-1" fill="none"
                                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                                        <path stroke-linecap="round"
                                                                            stroke-linejoin="round" stroke-width="2"
                                                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                                        <path stroke-linecap="round"
                                                                            stroke-linejoin="round" stroke-width="2"
                                                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                                    </svg>
                                                                    View Details
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        @endif
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
