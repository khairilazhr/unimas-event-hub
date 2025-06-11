<x-app-layout>
    <div class="flex flex-col min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800">
    <main class="flex-grow py-8 md:py-12 lg:py-16">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                
                @if(session('success'))
                    <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg dark:bg-green-900/20 dark:border-green-800 dark:text-green-400">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg dark:bg-red-900/20 dark:border-red-800 dark:text-red-400">
                        {{ session('error') }}
                    </div>
                @endif

                @if(isset($registration) && isset($ticketId))
                    <!-- Refund Request Form -->
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 mb-8">
                        <div class="mb-6">
                            <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Request Refund</h1>
                            <p class="text-gray-600 dark:text-gray-400">Submit a refund request for your ticket booking.</p>
                        </div>

                        <!-- Event Details -->
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6 mb-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Event Details</h3>
                            
                            <!-- Event Basic Info -->
                            <div class="mb-6">
                                <h4 class="text-xl font-bold text-gray-900 dark:text-white mb-2">{{ $registration->event->name }}</h4>
                                @if($registration->event->description)
                                    <p class="text-gray-700 dark:text-gray-300 mb-4 leading-relaxed">{{ $registration->event->description }}</p>
                                @endif
                            </div>

                            <!-- Event Info Grid -->
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
                                <div>
                                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">Event Date</p>
                                    <p class="text-gray-900 dark:text-white">
                                        {{ \Carbon\Carbon::parse($registration->event->date)->format('F d, Y \a\t g:i A') }}
                                    </p>
                                </div>
                                
                                <div>
                                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">Location</p>
                                    <p class="text-gray-900 dark:text-white">{{ $registration->event->location }}</p>
                                </div>
                                
                                <div>
                                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">Organizer</p>
                                    <p class="text-gray-900 dark:text-white">{{ $registration->event->organizer_name }}</p>
                                </div>
                                
                                @if($registration->event->refund_type)
                                <div>
                                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">Refund Type</p>
                                    <p class="text-gray-900 dark:text-white">{{ ucfirst($registration->event->refund_type) }}</p>
                                </div>
                                @endif
                                
                                <div>
                                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">Total Participants</p>
                                    <p class="text-gray-900 dark:text-white">{{ $registration->event->total_participants }}</p>
                                </div>
                            </div>

                            @if($registration->event->refund_policy)
                            <!-- Refund Policy -->
                            <div class="mb-6">
                                <h5 class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-2">Refund Policy</h5>
                                <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                                    <p class="text-blue-800 dark:text-blue-300 text-sm leading-relaxed">{{ $registration->event->refund_policy }}</p>
                                </div>
                            </div>
                            @endif

                            <!-- Booking Details -->
                            <div class="border-t border-gray-200 dark:border-gray-600 pt-6">
                                <h5 class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-3">Your Booking Details</h5>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">Ticket Type</p>
                                        <p class="font-medium text-gray-900 dark:text-white">{{ $registration->ticket->type }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">Ticket Price</p>
                                        <p class="font-medium text-gray-900 dark:text-white">
                                            ${{ number_format($registration->ticket->price, 2) }}
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">Registration Date</p>
                                        <p class="font-medium text-gray-900 dark:text-white">{{ $registration->created_at->format('M d, Y') }}</p>
                                    </div>
                                </div>

                                @if($registration->ticket->description)
                                <div class="mt-4">
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Ticket Description</p>
                                    <p class="text-gray-900 dark:text-white">{{ $registration->ticket->description }}</p>
                                </div>
                                @endif

                                @if($registration->ticket->section || $registration->ticket->row || $registration->ticket->seat)
                                <div class="mt-4">
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Seating Information</p>
                                    <p class="text-gray-900 dark:text-white">
                                        @if($registration->ticket->section)Section: {{ $registration->ticket->section }}@endif
                                        @if($registration->ticket->row)@if($registration->ticket->section), @endif Row: {{ $registration->ticket->row }}@endif
                                        @if($registration->ticket->seat)@if($registration->ticket->section || $registration->ticket->row), @endif Seat: {{ $registration->ticket->seat }}@endif
                                    </p>
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- Refund Form -->
                        <form action="{{ route('user.refunds.store') }}" method="POST" class="space-y-6">
                            @csrf
                            <input type="hidden" name="ticket_id" value="{{ $ticketId }}">

                            <div>
                                <label for="refund_reason" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Reason for Refund <span class="text-red-500">*</span>
                                </label>
                                <textarea 
                                    id="refund_reason" 
                                    name="refund_reason" 
                                    rows="4" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-blue-400"
                                    placeholder="Please explain why you are requesting a refund..."
                                    required>{{ old('refund_reason') }}</textarea>
                                @error('refund_reason')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex flex-col sm:flex-row gap-4 pt-4">
                                <button 
                                    type="submit" 
                                    class="inline-flex items-center justify-center px-6 py-3 bg-orange-600 hover:bg-orange-700 text-white font-medium rounded-lg transition-colors focus:ring-2 focus:ring-orange-500 focus:ring-offset-2"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                                    </svg>
                                    Submit Refund Request
                                </button>
                                <a 
                                    href="{{ route('user.events.my-bookings') }}" 
                                    class="inline-flex items-center justify-center px-6 py-3 bg-gray-300 hover:bg-gray-400 text-gray-700 font-medium rounded-lg transition-colors focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:bg-gray-600 dark:hover:bg-gray-500 dark:text-white"
                                >
                                    Cancel
                                </a>
                            </div>
                        </form>
                    </div>

                @else
                    <!-- Refund History -->
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
                        <div class="text-right mt-4"> 
                            <a 
                                href="{{ route('user.events.my-bookings') }}" 
                                class="inline-flex items-center justify-center px-2 py-0.5 bg-gray-300 hover:bg-gray-400 text-gray-700 text-xs font-medium rounded-lg transition-colors focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:bg-gray-600 dark:hover:bg-gray-500 dark:text-white"
                            >
                                Back to My Bookings
                            </a>
                        </div>
                        <div class="mb-6">
                            <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Refund Requests</h1>
                            <p class="text-gray-600 dark:text-gray-400">View your refund request history and status.</p>
                        </div>

                        @if(isset($refunds) && $refunds->count() > 0)
                            <div class="space-y-4">
                                @foreach($refunds as $refund)
                                    <div class="border border-gray-200 dark:border-gray-600 rounded-lg p-4">
                                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4">
                                            <div>
                                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                                    Refund Request #{{ $refund->id }}
                                                </h3>
                                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                                    {{ $refund->eventRegistration->event->name ?? 'N/A' }}
                                                </p>
                                            </div>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium mt-2 sm:mt-0
                                                @if($refund->status === 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900/20 dark:text-yellow-400
                                                @elseif($refund->status === 'approved') bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400
                                                @elseif($refund->status === 'rejected') bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-400
                                                @else bg-gray-100 text-gray-800 dark:bg-gray-900/20 dark:text-gray-400
                                                @endif">
                                                {{ ucfirst($refund->status) }}
                                            </span>
                                        </div>
                                        
                                        <!-- Event Info for History -->
                                        @if($refund->eventRegistration && $refund->eventRegistration->event)
                                        <div class="bg-gray-50 dark:bg-gray-600 rounded-lg p-4 mb-4">
                                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 text-sm">
                                                <div>
                                                    <p class="text-gray-600 dark:text-gray-400">Event Date</p>
                                                    <p class="font-medium text-gray-900 dark:text-white">
                                                        {{ \Carbon\Carbon::parse($refund->eventRegistration->event->date)->format('M d, Y') }}
                                                    </p>
                                                </div>
                                                <div>
                                                    <p class="text-gray-600 dark:text-gray-400">Location</p>
                                                    <p class="font-medium text-gray-900 dark:text-white">
                                                        {{ $refund->eventRegistration->event->location }}
                                                    </p>
                                                </div>
                                                <div>
                                                    <p class="text-gray-600 dark:text-gray-400">Organizer</p>
                                                    <p class="font-medium text-gray-900 dark:text-white">
                                                        {{ $refund->eventRegistration->event->organizer_name }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                        
                                        <div class="grid grid-cols-1 sm:grid-cols-4 gap-4 text-sm">
                                            <div>
                                                <p class="text-gray-600 dark:text-gray-400">Refund Amount</p>
                                                <p class="font-medium text-gray-900 dark:text-white">${{ number_format($refund->refund_amount, 2) }}</p>
                                            </div>
                                            <div>
                                                <p class="text-gray-600 dark:text-gray-400">Request Date</p>
                                                <p class="font-medium text-gray-900 dark:text-white">{{ $refund->created_at->format('M d, Y') }}</p>
                                            </div>
                                            <div>
                                                <p class="text-gray-600 dark:text-gray-400">Ticket Type</p>
                                                <p class="font-medium text-gray-900 dark:text-white">{{ $refund->ticket->type ?? 'N/A' }}</p>
                                            </div>
                                            <div>
                                                <p class="text-gray-600 dark:text-gray-400">Reason</p>
                                                <p class="font-medium text-gray-900 dark:text-white">{{ Str::limit($refund->refund_reason, 50) }}</p>
                                            </div>
                                        </div>
                                        
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-12">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">No Refund Requests</h3>
                                <p class="text-gray-600 dark:text-gray-400">You haven't submitted any refund requests yet.</p>
                            </div>
                        @endif
                    </div>
                @endif
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
                        <div class="flex space-x-4">
                            <a href="#" class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300">
                                <span class="sr-only">Facebook</span>
                                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" />
                                </svg>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300">
                                <span class="sr-only">Instagram</span>
                                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd" />
                                </svg>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300">
                                <span class="sr-only">Twitter</span>
                                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" />
                                </svg>
                            </a>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-base font-semibold text-gray-800 dark:text-white mb-4">Resources</h3>
                        <div class="grid grid-cols-2 gap-2">
                            <a href="#" class="text-sm text-gray-600 dark:text-gray-400 hover:text-unimasblue dark:hover:text-unimasblue transition">FAQ</a>
                            <a href="#" class="text-sm text-gray-600 dark:text-gray-400 hover:text-unimasblue dark:hover:text-unimasblue transition">Help Center</a>
                            <a href="#" class="text-sm text-gray-600 dark:text-gray-400 hover:text-unimasblue dark:hover:text-unimasblue transition">User Guide</a>
                            <a href="#" class="text-sm text-gray-600 dark:text-gray-400 hover:text-unimasblue dark:hover:text-unimasblue transition">Terms</a>
                            <a href="#" class="text-sm text-gray-600 dark:text-gray-400 hover:text-unimasblue dark:hover:text-unimasblue transition">Privacy</a>
                            <a href="#" class="text-sm text-gray-600 dark:text-gray-400 hover:text-unimasblue dark:hover:text-unimasblue transition">Contact</a>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-base font-semibold text-gray-800 dark:text-white mb-4">Need Help?</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                            Have questions or need assistance? Our support team is here to help you.
                        </p>
                        <button class="inline-flex items-center px-4 py-2.5 text-sm font-medium text-white bg-gray-700 hover:bg-gray-600 focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600 rounded-lg transition">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                            </svg>
                            Contact Support
                        </button>
                    </div>
                </div>

                <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700 text-center text-sm text-gray-500 dark:text-gray-400">
                    <p>© 2025 EventHub. All rights reserved.</p>
                </div>
            </div>
        </footer>
    </div>
</x-app-layout>
