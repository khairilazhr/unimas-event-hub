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
<div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700 animate-fadeIn" style="animation-delay: 600ms">
    <div class="flex flex-wrap gap-3">
        <!-- Cancel Booking Button - Only shown when status is pending -->
        @if($registration->status == 'pending' && \Carbon\Carbon::parse($registration->event->date)->isFuture())
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
        @endif

        <!-- Digital Ticket Button - Only shown when status is confirmed -->
        @if($registration->status == 'confirmed' && \Carbon\Carbon::parse($registration->event->date)->isFuture())
            <button type="button"
                    id="showTicketBtn"
                    class="px-5 py-2.5 bg-unimasblue text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-all duration-300 hover:shadow-md transform hover:translate-y-[-1px] flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                </svg>
                Digital Ticket
            </button>
        @endif
    </div>
</div>
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
        <!-- Digital Ticket Modal -->
<div id="ticketModal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" id="modalOverlay"></div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-sm sm:w-full">
            <div class="bg-white dark:bg-gray-800 p-4">
                <div class="sm:flex sm:items-start">
                    <div class="w-full">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white" id="modal-title">
                                Digital Ticket
                            </h3>
                            <button type="button" id="closeModalBtn" class="text-gray-400 hover:text-gray-500">
                                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        <!-- Ticket Container -->
                        <div id="printableTicket" class="bg-white rounded-lg overflow-hidden border border-gray-200 shadow-md" style="max-width: 360px; margin: 0 auto;">
                            <!-- Ticket Header -->
                            <div class="bg-unimasblue text-white p-4 text-center">
                                <div class="text-xs uppercase tracking-wide font-semibold mb-1">Event Ticket</div>
                                <h2 class="text-xl font-bold truncate">{{ $registration->event->name }}</h2>
                            </div>

                            <!-- Event Info Section -->
                            <div class="p-4 border-b border-gray-200">
                                <div class="flex items-center justify-between mb-3">
                                    <div>
                                        <div class="text-xs text-gray-500">Date & Time</div>
                                        <div class="font-semibold">{{ \Carbon\Carbon::parse($registration->event->date)->format('d M Y') }}</div>
                                        <div class="text-sm">{{ \Carbon\Carbon::parse($registration->event->date)->format('h:i A') }}</div>
                                    </div>
                                    <div class="text-right">
                                        <div class="text-xs text-gray-500">Location</div>
                                        <div class="font-semibold">{{ $registration->event->location }}</div>
                                    </div>
                                </div>

                                <div class="py-2">
                                    <div class="text-xs text-gray-500">Attendee</div>
                                    <div class="font-semibold">{{ $registration->name }}</div>
                                </div>
                            </div>

                            <!-- Ticket Info Section -->
                            <div class="p-4 border-b border-gray-200">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <div class="text-xs text-gray-500">Section</div>
                                        <div class="font-semibold">{{ $registration->ticket->section }}</div>
                                    </div>
                                    <div class="text-center">
                                        <div class="text-xs text-gray-500">Row</div>
                                        <div class="font-semibold">{{ $registration->ticket->row }}</div>
                                    </div>
                                    <div class="text-right">
                                        <div class="text-xs text-gray-500">Seat</div>
                                        <div class="font-semibold">{{ $registration->ticket->seat }}</div>
                                    </div>
                                </div>

                                <div class="mt-3">
                                    <div class="text-xs text-gray-500">Ticket Type</div>
                                    <div class="font-semibold">{{ $registration->ticket->type }}</div>
                                </div>
                            </div>

                            <!-- QR Code Section -->
                            <div class="p-4 text-center">
                                <div id="qrCode" class="bg-white inline-block p-2 mb-2 shadow-sm rounded"></div>
                                <div class="text-xs text-gray-500">Ticket #{{ $registration->id }}</div>
                            </div>

                            <!-- Ticket Footer -->
                            <div class="bg-gray-50 p-3 text-center text-xs text-gray-500">
                                <p>Present this ticket at the entrance.</p>
                                <p>{{ config('app.name') }} • {{ date('Y') }}</p>
                            </div>
                        </div>

                        <!-- Print Button -->
                        <div class="mt-4 text-center">
                            <button type="button"
                                    id="printTicketBtn"
                                    class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:text-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                </svg>
                                Print Ticket
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
        <!-- End of Digital Ticket Modal -->

    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Define variables
        const showTicketBtn = document.getElementById('showTicketBtn');
        const ticketModal = document.getElementById('ticketModal');
        const closeModalBtn = document.getElementById('closeModalBtn');
        const modalOverlay = document.getElementById('modalOverlay');
        const printTicketBtn = document.getElementById('printTicketBtn');

        // Function to generate QR code
        function generateQRCode() {
            const qrCodeContainer = document.getElementById('qrCode');
            if (qrCodeContainer) {
                qrCodeContainer.innerHTML = '';

                // Create QR code with registration information
                const qrCodeData = JSON.stringify({
                    id: "{{ $registration->id }}",
                    event_id: "{{ $registration->event_id }}",
                    ticket_id: "{{ $registration->ticket_id }}",
                    status: "{{ $registration->status }}",
                    name: "{{ $registration->name }}",
                    email: "{{ $registration->email }}",
                    section: "{{ $registration->ticket->section }}",
                    row: "{{ $registration->ticket->row }}",
                    seat: "{{ $registration->ticket->seat }}"
                });

                // Create QR code
                new QRCode(qrCodeContainer, {
                    text: qrCodeData,
                    width: 150,
                    height: 150,
                    colorDark: "#000000",
                    colorLight: "#ffffff",
                    correctLevel: QRCode.CorrectLevel.H
                });
            }
        }

        // Show modal and generate QR code
        if (showTicketBtn) {
            showTicketBtn.addEventListener('click', function() {
                ticketModal.classList.remove('hidden');
                generateQRCode();
            });
        }

        // Close modal
        if (closeModalBtn) {
            closeModalBtn.addEventListener('click', function() {
                ticketModal.classList.add('hidden');
            });
        }

        // Close modal when clicking overlay
        if (modalOverlay) {
            modalOverlay.addEventListener('click', function() {
                ticketModal.classList.add('hidden');
            });
        }

        // Print ticket
        if (printTicketBtn) {
            printTicketBtn.addEventListener('click', function() {
                const printContent = document.getElementById('printableTicket');
                const originalContent = document.body.innerHTML;

                // Create a print-friendly version of the ticket
                document.body.innerHTML = `
                    <style>
                        @page {
                            size: 100mm 180mm;
                            margin: 0;
                        }
                        body {
                            margin: 0;
                            padding: 0;
                            font-family: 'Arial', sans-serif;
                            background-color: #ffffff;
                        }
                        .ticket-container {
                            width: 100%;
                            max-width: 360px;
                            margin: 0 auto;
                            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
                            border-radius: 8px;
                            overflow: hidden;
                            background-color: #ffffff;
                        }
                        .ticket-header {
                            background-color: #003366;
                            color: white;
                            padding: 16px;
                            text-align: center;
                        }
                        .ticket-header h2 {
                            margin: 0;
                            font-size: 18px;
                            font-weight: bold;
                        }
                        .ticket-header .subtitle {
                            font-size: 12px;
                            text-transform: uppercase;
                            letter-spacing: 1px;
                            margin-bottom: 4px;
                        }
                        .ticket-section {
                            padding: 16px;
                            border-bottom: 1px solid #e5e5e5;
                        }
                        .ticket-row {
                            display: flex;
                            justify-content: space-between;
                            margin-bottom: 12px;
                        }
                        .ticket-column {
                            flex: 1;
                        }
                        .ticket-label {
                            font-size: 11px;
                            color: #666;
                            margin-bottom: 2px;
                        }
                        .ticket-value {
                            font-size: 14px;
                            font-weight: 600;
                        }
                        .qr-container {
                            text-align: center;
                            padding: 16px;
                        }
                        .ticket-id {
                            font-size: 11px;
                            color: #666;
                            margin-top: 8px;
                        }
                        .ticket-footer {
                            padding: 12px;
                            text-align: center;
                            background-color: #f8f8f8;
                            font-size: 10px;
                            color: #666;
                        }
                        .align-right {
                            text-align: right;
                        }
                        .align-center {
                            text-align: center;
                        }
                    </style>
                    <div class="ticket-container">
                        <div class="ticket-header">
                            <div class="subtitle">Event Ticket</div>
                            <h2>${"{{ $registration->event->name }}"}</h2>
                        </div>

                        <div class="ticket-section">
                            <div class="ticket-row">
                                <div class="ticket-column">
                                    <div class="ticket-label">Date & Time</div>
                                    <div class="ticket-value">{{ \Carbon\Carbon::parse($registration->event->date)->format('d M Y') }}</div>
                                    <div>{{ \Carbon\Carbon::parse($registration->event->date)->format('h:i A') }}</div>
                                </div>
                                <div class="ticket-column align-right">
                                    <div class="ticket-label">Location</div>
                                    <div class="ticket-value">${"{{ $registration->event->location }}"}</div>
                                </div>
                            </div>

                            <div class="ticket-row">
                                <div class="ticket-column">
                                    <div class="ticket-label">Attendee</div>
                                    <div class="ticket-value">${"{{ $registration->name }}"}</div>
                                </div>
                            </div>
                        </div>

                        <div class="ticket-section">
                            <div class="ticket-row">
                                <div class="ticket-column">
                                    <div class="ticket-label">Section</div>
                                    <div class="ticket-value">${"{{ $registration->ticket->section }}"}</div>
                                </div>
                                <div class="ticket-column align-center">
                                    <div class="ticket-label">Row</div>
                                    <div class="ticket-value">${"{{ $registration->ticket->row }}"}</div>
                                </div>
                                <div class="ticket-column align-right">
                                    <div class="ticket-label">Seat</div>
                                    <div class="ticket-value">${"{{ $registration->ticket->seat }}"}</div>
                                </div>
                            </div>

                            <div class="ticket-row">
                                <div class="ticket-column">
                                    <div class="ticket-label">Ticket Type</div>
                                    <div class="ticket-value">${"{{ $registration->ticket->type }}"}</div>
                                </div>
                            </div>
                        </div>

                        <div class="qr-container">
                            ${document.getElementById('qrCode').innerHTML}
                            <div class="ticket-id">Ticket #${"{{ $registration->id }}"}</div>
                        </div>

                        <div class="ticket-footer">
                            <p>Present this ticket at the entrance.</p>
                            <p>${"{{ config('app.name') }}"} • ${"{{ date('Y') }}"}</p>
                        </div>
                    </div>
                `;

                // Print the document
                window.print();

                // Restore the original content
                document.body.innerHTML = originalContent;

                // Reinitialize event listeners and QR code
                setTimeout(function() {
                    const showTicketBtn = document.getElementById('showTicketBtn');
                    const ticketModal = document.getElementById('ticketModal');
                    const closeModalBtn = document.getElementById('closeModalBtn');
                    const modalOverlay = document.getElementById('modalOverlay');
                    const printTicketBtn = document.getElementById('printTicketBtn');

                    // Show modal and generate QR code
                    if (showTicketBtn) {
                        showTicketBtn.addEventListener('click', function() {
                            ticketModal.classList.remove('hidden');
                            generateQRCode();
                        });
                    }

                    // Close modal
                    if (closeModalBtn) {
                        closeModalBtn.addEventListener('click', function() {
                            ticketModal.classList.add('hidden');
                        });
                    }

                    // Close modal when clicking overlay
                    if (modalOverlay) {
                        modalOverlay.addEventListener('click', function() {
                            ticketModal.classList.add('hidden');
                        });
                    }

                    // Reinitialize print functionality
                    if (printTicketBtn) {
                        printTicketBtn.addEventListener('click', function() {
                            // Print functionality code
                        });
                    }

                    // Regenerate QR code
                    generateQRCode();
                }, 1000);
            });
        }
    });
</script>

</x-app-layout>
