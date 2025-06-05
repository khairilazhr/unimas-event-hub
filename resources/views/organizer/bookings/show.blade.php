<x-app-layout>
    <div class="min-h-screen flex flex-col">
        <main class="flex-grow py-6 sm:py-8 md:py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 shadow-lg sm:rounded-xl overflow-hidden">
                    <div class="relative bg-unimasblue dark:bg-unimasblue p-6">
                        <div class="absolute inset-0 opacity-10 bg-pattern-grid"></div>
                        <h1 class="text-2xl sm:text-3xl font-bold text-center text-white">
                            Booking Details
                        </h1>
                    </div>
                    <div class="p-4 sm:p-6 md:p-8">
                        @if(session('success'))
                            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                                {{ session('error') }}
                            </div>
                        @endif

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Event Details -->
                            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                <h2 class="text-lg font-semibold mb-4">Event Information</h2>
                                <dl class="space-y-2">
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Event Name</dt>
                                        <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $registration->event->name }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Event Date</dt>
                                        <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($registration->event->date)->format('M d, Y') }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Location</dt>
                                        <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $registration->event->location }}</dd>
                                    </div>
                                </dl>
                            </div>

                            <!-- Ticket Details -->
                            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                <h2 class="text-lg font-semibold mb-4">Ticket Information</h2>
                                <dl class="space-y-2">
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Ticket Type</dt>
                                        <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $registration->ticket->type }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Seat Details</dt>
                                        <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                                            Section {{ $registration->ticket->section }}, 
                                            Row {{ $registration->ticket->row }}, 
                                            Seat {{ $registration->ticket->seat }}
                                        </dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Price</dt>
                                        <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                                            RM{{ number_format($registration->ticket->price, 2) }}
                                        </dd>
                                    </div>
                                </dl>
                            </div>

                            <!-- Attendee Details -->
                            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                <h2 class="text-lg font-semibold mb-4">Attendee Information</h2>
                                <dl class="space-y-2">
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Name</dt>
                                        <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $registration->name }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Email</dt>
                                        <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $registration->email }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Phone</dt>
                                        <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $registration->phone }}</dd>
                                    </div>
                                    @if($registration->user)
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">User ID</dt>
                                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $registration->user->id }}</dd>
                                        </div>
                                    @endif
                                </dl>
                            </div>

                            <!-- Payment Details -->
                            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                <h2 class="text-lg font-semibold mb-4">Payment Details</h2>
                                <dl class="space-y-2">
                                @if($registration->payment && $registration->payment->receipt)
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Payment Receipt</dt>
                                        <dd class="mt-1">
                                            @php
                                                $receipt = $registration->payment->receipt;
                                                $extension = pathinfo($receipt, PATHINFO_EXTENSION);
                                                $exists = Storage::disk('public')->exists($receipt);
                                                $fileUrl = $exists ? asset('storage/' . $receipt) : null;
                                            @endphp
                                            
                                            <div class="flex items-center space-x-2">
                                                @if($exists && $fileUrl)
                                                    <a href="{{ $fileUrl }}" 
                                                    target="_blank"
                                                    class="text-blue-600 hover:text-blue-800 flex items-center">
                                                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                        </svg>
                                                        View Receipt
                                                    </a>
                                                    <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs uppercase">
                                                        {{ $extension }}
                                                    </span>
                                                @else
                                                    <span class="text-sm text-gray-500">Receipt file not found ({{ $receipt }})</span>
                                                @endif
                                            </div>
                                        </dd>
                                    </div>
                                @else
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Receipt</dt>
                                        <dd class="mt-1 text-sm text-gray-500">No receipt uploaded</dd>
                                    </div>
                                @endif
                                </dl>
                            </div>
                        </div>

                        <!-- Approve/Reject Buttons -->
                        @if($registration->status == 'pending')
                        <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700 flex justify-end space-x-4">
                            <form action="{{ route('organizer.approve.booking', $registration->id) }}" method="POST">
                                @csrf
                                <button type="submit" 
                                        class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                                    Approve Booking
                                </button>
                            </form>
                            <form action="{{ route('organizer.reject.booking', $registration->id) }}" method="POST">
                                @csrf
                                <button type="submit" 
                                        class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                                    Reject Booking
                                </button>
                            </form>
                        </div>
                        @endif

                        <div class="mt-6">
                            <a href="{{ route('organizer.bookings') }}" 
                               class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                                ← Back to Bookings
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</x-app-layout>