<x-app-layout>
    <div class="min-h-screen flex flex-col">
        <main class="flex-grow py-4">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Back Button -->
                <div class="mb-4">
                    <a href="{{ route('organizer.events') }}"
                        class="inline-flex items-center text-sm text-gray-600 hover:text-unimasblue transition">
                        <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                        Back to My Events
                    </a>
                </div>

                <div class="bg-white dark:bg-gray-800 shadow-lg sm:rounded-xl overflow-hidden">
                    <!-- Header with Event Status -->
                    <div class="relative bg-unimasblue p-4">
                        <div class="absolute inset-0 opacity-10 bg-pattern-grid"></div>
                        <div class="flex justify-between items-center">
                            <h1 class="text-xl font-bold text-white">{{ $event->name }}</h1>
                            <span
                                class="px-3 py-1 text-sm font-semibold rounded-full @if ($event->status == 'approved') bg-green-100 text-green-800 @elseif($event->status == 'pending') bg-yellow-100 text-yellow-800 @else bg-red-100 text-red-800 @endif">
                                {{ ucfirst($event->status ?? 'unknown') }}
                            </span>
                        </div>
                    </div>

                    <div class="p-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Left Column: Event Details -->
                        <div class="space-y-4">
                            <!-- Event Info -->
                            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-3 grid grid-cols-2 gap-3">
                                <div>
                                    <p class="text-sm text-gray-500">Date & Time</p>
                                    <p class="text-gray-700 dark:text-gray-300">
                                        {{ $event->date ? \Carbon\Carbon::parse($event->date)->format('M j, Y g:i A') : '-' }}
                                    </p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Location</p>
                                    <p class="text-gray-700 dark:text-gray-300">{{ $event->location ?? '-' }}</p>
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-3">
                                <p class="text-sm text-gray-500">Description</p>
                                <p class="text-gray-700 dark:text-gray-300">{{ $event->description }}</p>
                            </div>

                            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-3">
                                <p class="text-sm text-gray-500">Refund Plicy</p>
                                <p class="text-gray-700 dark:text-gray-300">{{ $event->refund_policy }}</p>
                            </div>

                            <!-- Quick Stats -->
                            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-3 grid grid-cols-3 text-center">
                                <div>
                                    <p class="text-xs text-gray-500">Registrations</p>
                                    <p class="text-lg font-bold text-gray-900 dark:text-white">
                                        {{ $event->registrations_count ?? 0 }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Created</p>
                                    <p class="text-sm text-gray-700 dark:text-gray-300">
                                        {{ $event->created_at->format('M j, Y') }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Updated</p>
                                    <p class="text-sm text-gray-700 dark:text-gray-300">
                                        {{ $event->updated_at->format('M j, Y') }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column: Tickets & Payment -->
                        <div class="space-y-4">
                            <!-- Payment Info -->
                            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-3 grid grid-cols-2 gap-4">
                                <div>
                                    @if ($event->qr_code)
                                        <img src="{{ asset('storage/' . $event->qr_code) }}" alt="QR Code"
                                            class="w-full h-auto rounded">
                                    @else
                                        <div
                                            class="w-full aspect-square flex items-center justify-center bg-gray-100 dark:bg-gray-600 rounded">
                                            <p class="text-xs text-gray-500">No QR code</p>
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500 mb-1">Payment Details</p>
                                    <p class="text-sm text-gray-700 dark:text-gray-300">
                                        {{ $event->payment_details ?? 'Not specified' }}</p>
                                </div>
                            </div>

                            <!-- Tickets -->
                            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-3">
                                <p class="text-sm text-gray-500 mb-2">Tickets</p>
                                <div class="space-y-2">
                                    @forelse($groupedTickets as $type => $tickets)
                                        <div class="flex justify-between text-sm">
                                            <span class="text-gray-700 dark:text-gray-300">{{ $type }}</span>
                                            <span class="font-medium">RM
                                                {{ number_format($tickets->first()->price, 2) }}</span>
                                        </div>
                                    @empty
                                        <p class="text-sm text-gray-500">No tickets available</p>
                                    @endforelse
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            @if ($event->status == 'approved' || $event->status == 'pending')
                                <div class="flex gap-2">
                                    <a href="{{ route('organizer.edit.event', $event->id) }}"
                                        class="flex-1 inline-flex items-center justify-center px-4 py-2 bg-unimasblue hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition">
                                        <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                        Edit Event
                                    </a>
                                </div>
                            @endif
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
