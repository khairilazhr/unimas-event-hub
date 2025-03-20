<x-app-layout>
    <div class="flex flex-col min-h-screen bg-gray-100 dark:bg-gray-900">
        {{-- Main Content --}}
        <main class="flex-grow py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 shadow-md sm:rounded-2xl p-8 sm:p-10">
                    <div class="flex justify-between items-center mb-8">
                        <h1 class="text-3xl font-bold text-gray-800 dark:text-white">
                            Booking Details
                        </h1>
                        
                        <a href="{{ route('user.events.my-bookings') }}" class="text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300 text-sm font-medium">
                            &larr; Back to My Bookings
                        </a>
                    </div>

                    <!-- Status Badge -->
                    <div class="mb-8">
                        <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full 
                            @if($registration->status == 'confirmed') 
                                bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100
                            @elseif($registration->status == 'pending')
                                bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100
                            @elseif($registration->status == 'cancelled')
                                bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100
                            @else
                                bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-100
                            @endif
                        ">
                            Status: {{ ucfirst($registration->status ?? 'unknown') }}
                        </span>
                        
                        @if($registration->status == 'pending')
                            <a href="{{ route('user.events.payment', $registration->id) }}" 
                               class="ml-4 px-4 py-1 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition">
                                Pay Now
                            </a>
                        @endif
                    </div>

                    <!-- Event Details -->
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6 mb-8">
                        <div class="mb-4">
                            <h2 class="text-xl font-bold text-gray-800 dark:text-white mb-1">{{ $registration->event->name }}</h2>
                            <p class="text-gray-600 dark:text-gray-400 text-sm">{{ $registration->event->description }}</p>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                            <div>
                                <p class="text-gray-500 dark:text-gray-400">Date & Time</p>
                                <p class="font-medium text-gray-800 dark:text-white">
                                    {{ \Carbon\Carbon::parse($registration->event->date)->format('d M Y, h:i A') }}
                                </p>
                            </div>
                            <div>
                                <p class="text-gray-500 dark:text-gray-400">Location</p>
                                <p class="font-medium text-gray-800 dark:text-white">{{ $registration->event->location }}</p>
                            </div>
                            <div>
                                <p class="text-gray-500 dark:text-gray-400">Organizer</p>
                                <p class="font-medium text-gray-800 dark:text-white">{{ $registration->event->organizer_name }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Ticket Information -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Ticket Information</h3>
                        
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6 border border-gray-200 dark:border-gray-600">
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                                <div>
                                    <p class="text-gray-500 dark:text-gray-400 text-sm">Ticket Type</p>
                                    <p class="font-medium text-gray-800 dark:text-white">{{ $registration->ticket->type }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-500 dark:text-gray-400 text-sm">Section</p>
                                    <p class="font-medium text-gray-800 dark:text-white">{{ $registration->ticket->section }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-500 dark:text-gray-400 text-sm">Row & Seat</p>
                                    <p class="font-medium text-gray-800 dark:text-white">Row {{ $registration->ticket->row }}, Seat {{ $registration->ticket->seat }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-500 dark:text-gray-400 text-sm">Price</p>
                                    <p class="font-medium text-gray-800 dark:text-white">RM{{ number_format($registration->ticket->price, 2) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Attendee Information -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Attendee Information</h3>
                        
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6 border border-gray-200 dark:border-gray-600">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <p class="text-gray-500 dark:text-gray-400 text-sm">Name</p>
                                    <p class="font-medium text-gray-800 dark:text-white">{{ $registration->name }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-500 dark:text-gray-400 text-sm">Email</p>
                                    <p class="font-medium text-gray-800 dark:text-white">{{ $registration->email }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-500 dark:text-gray-400 text-sm">Phone</p>
                                    <p class="font-medium text-gray-800 dark:text-white">{{ $registration->phone ?: 'Not provided' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Booking Details -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Booking Details</h3>
                        
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6 border border-gray-200 dark:border-gray-600">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <p class="text-gray-500 dark:text-gray-400 text-sm">Booking ID</p>
                                    <p class="font-medium text-gray-800 dark:text-white">{{ $registration->id }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-500 dark:text-gray-400 text-sm">Booked On</p>
                                    <p class="font-medium text-gray-800 dark:text-white">{{ $registration->created_at->format('d M Y, h:i A') }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-500 dark:text-gray-400 text-sm">Last Updated</p>
                                    <p class="font-medium text-gray-800 dark:text-white">{{ $registration->updated_at->format('d M Y, h:i A') }}</p>
                                </div>
                            </div>
                            
                            @if($registration->notes)
                                <div class="mt-4">
                                    <p class="text-gray-500 dark:text-gray-400 text-sm">Notes</p>
                                    <p class="font-medium text-gray-800 dark:text-white">{{ $registration->notes }}</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    @if($registration->status != 'cancelled' && \Carbon\Carbon::parse($registration->event->date)->isFuture())
                        <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
                            <form method="POST" action="{{ route('user.events.cancel-registration', $registration->id) }}" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 transition"
                                        onclick="return confirm('Are you sure you want to cancel this booking?')">
                                    Cancel Booking
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </main>

        {{-- Footer --}}
        <footer class="bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 shadow-inner">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-3">Resources</h3>
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                            <a href="#" class="text-sm text-gray-600 dark:text-gray-400 hover:underline">FAQ</a>
                            <a href="#" class="text-sm text-gray-600 dark:text-gray-400 hover:underline">Help Center</a>
                            <a href="#" class="text-sm text-gray-600 dark:text-gray-400 hover:underline">User Guide</a>
                            <a href="#" class="text-sm text-gray-600 dark:text-gray-400 hover:underline">Terms</a>
                            <a href="#" class="text-sm text-gray-600 dark:text-gray-400 hover:underline">Privacy</a>
                            <a href="#" class="text-sm text-gray-600 dark:text-gray-400 hover:underline">Contact</a>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-3">Need Help?</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                            Have questions or need assistance? We're here to help.
                        </p>
                        <button
                            class="inline-block px-4 py-2 text-sm font-medium text-white bg-gray-700 hover:bg-gray-600 rounded-lg transition">
                            Contact Support
                        </button>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</x-app-layout>