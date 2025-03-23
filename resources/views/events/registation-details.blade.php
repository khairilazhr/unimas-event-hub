<x-app-layout>
    <div class="flex flex-col min-h-screen bg-gray-50 dark:bg-gray-900">
        {{-- Main Content --}}
        <main class="flex-grow py-12 px-4 sm:px-6 lg:px-8 transition-all duration-300">
            <div class="max-w-5xl mx-auto">
                <div class="bg-white dark:bg-gray-800 shadow-lg sm:rounded-xl overflow-hidden mb-8 transition-all duration-300 hover:shadow-xl animate-fadeIn">
                    <!-- Header Section with Gradient -->
                    <div class="bg-unimasblue p-6 sm:p-8">
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                            <h1 class="text-2xl sm:text-3xl font-bold text-white">
                                Booking Details
                            </h1>
                            
                            <a href="{{ route('user.events.my-bookings') }}" 
                               class="group flex items-center text-white text-sm font-medium transition-all duration-300 hover:translate-x-[-4px]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 transition-transform duration-300 group-hover:transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                </svg>
                                Back to My Bookings
                            </a>
                        </div>
                    </div>

                    <div class="p-6 sm:p-8">
                        <!-- Status Badge -->
                        <div class="mb-8 animate-slideInFromRight" style="animation-delay: 100ms">
                            <div class="flex flex-wrap items-center gap-3">
                                <span class="px-4 py-1.5 inline-flex items-center text-sm leading-5 font-medium rounded-full transition-all duration-300 
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
                                    <span class="w-2 h-2 rounded-full mr-2
                                        @if($registration->status == 'confirmed') 
                                            bg-green-500
                                        @elseif($registration->status == 'pending')
                                            bg-yellow-500
                                        @elseif($registration->status == 'cancelled')
                                            bg-red-500
                                        @else
                                            bg-gray-500
                                        @endif
                                    "></span>
                                    {{ ucfirst($registration->status ?? 'unknown') }}
                                </span>
                                
                                @if($registration->status == 'pending')
                                    <a href="{{ route('user.events.payment', $registration->id) }}" 
                                       class="inline-flex items-center px-4 py-1.5 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition-all duration-300 hover:shadow-md transform hover:translate-y-[-1px]">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                        </svg>
                                        Pay Now
                                    </a>
                                @endif
                            </div>
                        </div>

                        <!-- Event Details -->
                        <div class="mb-8 rounded-xl overflow-hidden transition-all duration-300 hover:shadow-md animate-slideInFromLeft" style="animation-delay: 200ms">
                            <div class="bg-gray-50 dark:bg-gray-700 p-6">
                                <div class="mb-4">
                                    <h2 class="text-xl font-bold text-gray-800 dark:text-white mb-2">{{ $registration->event->name }}</h2>
                                    <p class="text-gray-600 dark:text-gray-400 text-sm">{{ $registration->event->description }}</p>
                                </div>
                                
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                                    <div class="flex gap-3 items-start">
                                        <div class="mt-0.5 text-unimasblue dark:text-unimasblue">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-gray-500 dark:text-gray-400 text-xs uppercase tracking-wide font-medium mb-1">Date & Time</p>
                                            <p class="font-medium text-gray-800 dark:text-white">
                                                {{ \Carbon\Carbon::parse($registration->event->date)->format('d M Y, h:i A') }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="flex gap-3 items-start">
                                        <div class="mt-0.5 text-unimasblue dark:text-unimasblue">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-gray-500 dark:text-gray-400 text-xs uppercase tracking-wide font-medium mb-1">Location</p>
                                            <p class="font-medium text-gray-800 dark:text-white">{{ $registration->event->location }}</p>
                                        </div>
                                    </div>
                                    <div class="flex gap-3 items-start">
                                        <div class="mt-0.5 text-unimasblue dark:text-unimasblue">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-gray-500 dark:text-gray-400 text-xs uppercase tracking-wide font-medium mb-1">Organizer</p>
                                            <p class="font-medium text-gray-800 dark:text-white">{{ $registration->event->organizer_name }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Information Sections -->
                        <div class="space-y-6">
                            <!-- Ticket Information -->
                            <div class="animate-slideInFromRight" style="animation-delay: 300ms">
                                <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-3 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-unimasblue" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                                    </svg>
                                    Ticket Information
                                </h3>
                                
                                <div class="bg-gray-50 dark:bg-gray-700 rounded-xl p-6 border border-gray-100 dark:border-gray-600 transition-all duration-300 hover:shadow-md">
                                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                                        <div>
                                            <p class="text-gray-500 dark:text-gray-400 text-xs uppercase tracking-wide font-medium mb-1">Ticket Type</p>
                                            <p class="font-medium text-gray-800 dark:text-white">{{ $registration->ticket->type }}</p>
                                        </div>
                                        <div>
                                            <p class="text-gray-500 dark:text-gray-400 text-xs uppercase tracking-wide font-medium mb-1">Section</p>
                                            <p class="font-medium text-gray-800 dark:text-white">{{ $registration->ticket->section }}</p>
                                        </div>
                                        <div>
                                            <p class="text-gray-500 dark:text-gray-400 text-xs uppercase tracking-wide font-medium mb-1">Row & Seat</p>
                                            <p class="font-medium text-gray-800 dark:text-white">Row {{ $registration->ticket->row }}, Seat {{ $registration->ticket->seat }}</p>
                                        </div>
                                        <div>
                                            <p class="text-gray-500 dark:text-gray-400 text-xs uppercase tracking-wide font-medium mb-1">Price</p>
                                            <p class="font-medium text-gray-800 dark:text-white">RM{{ number_format($registration->ticket->price, 2) }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Attendee Information -->
                            <div class="animate-slideInFromLeft" style="animation-delay: 400ms">
                                <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-3 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-unimasblue" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    Attendee Information
                                </h3>
                                
                                <div class="bg-gray-50 dark:bg-gray-700 rounded-xl p-6 border border-gray-100 dark:border-gray-600 transition-all duration-300 hover:shadow-md">
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                        <div>
                                            <p class="text-gray-500 dark:text-gray-400 text-xs uppercase tracking-wide font-medium mb-1">Name</p>
                                            <p class="font-medium text-gray-800 dark:text-white">{{ $registration->name }}</p>
                                        </div>
                                        <div>
                                            <p class="text-gray-500 dark:text-gray-400 text-xs uppercase tracking-wide font-medium mb-1">Email</p>
                                            <p class="font-medium text-gray-800 dark:text-white">{{ $registration->email }}</p>
                                        </div>
                                        <div>
                                            <p class="text-gray-500 dark:text-gray-400 text-xs uppercase tracking-wide font-medium mb-1">Phone</p>
                                            <p class="font-medium text-gray-800 dark:text-white">{{ $registration->phone ?: 'Not provided' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Booking Details -->
                            <div class="animate-slideInFromRight" style="animation-delay: 500ms">
                                <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-3 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-unimasblue" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                    Booking Details
                                </h3>
                                
                                <div class="bg-gray-50 dark:bg-gray-700 rounded-xl p-6 border border-gray-100 dark:border-gray-600 transition-all duration-300 hover:shadow-md">
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                        <div>
                                            <p class="text-gray-500 dark:text-gray-400 text-xs uppercase tracking-wide font-medium mb-1">Booking ID</p>
                                            <p class="font-medium text-gray-800 dark:text-white">{{ $registration->id }}</p>
                                        </div>
                                        <div>
                                            <p class="text-gray-500 dark:text-gray-400 text-xs uppercase tracking-wide font-medium mb-1">Booked On</p>
                                            <p class="font-medium text-gray-800 dark:text-white">{{ $registration->created_at->format('d M Y, h:i A') }}</p>
                                        </div>
                                        <div>
                                            <p class="text-gray-500 dark:text-gray-400 text-xs uppercase tracking-wide font-medium mb-1">Last Updated</p>
                                            <p class="font-medium text-gray-800 dark:text-white">{{ $registration->updated_at->format('d M Y, h:i A') }}</p>
                                        </div>
                                    </div>
                                    
                                    @if($registration->notes)
                                        <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-600">
                                            <p class="text-gray-500 dark:text-gray-400 text-xs uppercase tracking-wide font-medium mb-1">Notes</p>
                                            <p class="font-medium text-gray-800 dark:text-white">{{ $registration->notes }}</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        @if($registration->status != 'cancelled' && \Carbon\Carbon::parse($registration->event->date)->isFuture())
                            <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700 animate-fadeIn" style="animation-delay: 600ms">
                                <form method="POST" action="{{ route('user.events.cancel-registration', $registration->id) }}" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="px-5 py-2.5 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 transition-all duration-300 hover:shadow-md transform hover:translate-y-[-1px] flex items-center"
                                            onclick="return confirm('Are you sure you want to cancel this booking?')">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                        Cancel Booking
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
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