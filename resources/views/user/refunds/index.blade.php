<x-app-layout>
    <div
        class="flex flex-col min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800">
        <main class="flex-grow py-8 md:py-12 lg:py-16">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

                @if (session('success'))
                    <div
                        class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg dark:bg-green-900/20 dark:border-green-800 dark:text-green-400">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div
                        class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg dark:bg-red-900/20 dark:border-red-800 dark:text-red-400">
                        {{ session('error') }}
                    </div>
                @endif

                @if (isset($registration) && isset($ticketId))
                    <!-- Refund Request Form -->
                    <div class="bg-white dark:bg-gray-800 shadow-lg sm:rounded-xl overflow-hidden mb-8">
                        <div class="relative bg-unimasblue dark:bg-unimasblue p-6">
                            <div class="absolute inset-0 opacity-10 bg-pattern-grid"></div>
                            <h1 class="text-2xl sm:text-3xl font-bold text-center text-white">
                                Request Refund
                            </h1>
                        </div>
                        <div class="p-4 sm:p-6 md:p-8">
                            <!-- Alert Messages -->
                            @if (session('success'))
                                <div
                                    class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg dark:bg-green-900/20 dark:border-green-800 dark:text-green-400">
                                    {{ session('success') }}
                                </div>
                            @endif
                            @if (session('error'))
                                <div
                                    class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg dark:bg-red-900/20 dark:border-red-800 dark:text-red-400">
                                    {{ session('error') }}
                                </div>
                            @endif

                            <!-- Event Details -->
                            <div class="mb-8">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Event Details</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                                    <div>
                                        <span class="block text-gray-500 dark:text-gray-400 font-medium">Event
                                            Name</span>
                                        <span class="text-gray-900 dark:text-white font-semibold">
                                            {{ $registration->event->name }}
                                        </span>
                                    </div>
                                    <div>
                                        <span class="block text-gray-500 dark:text-gray-400 font-medium">Event
                                            Date</span>
                                        <span class="text-gray-900 dark:text-white">
                                            {{ \Carbon\Carbon::parse($registration->event->date)->format('F d, Y \a\t g:i A') }}
                                        </span>
                                    </div>
                                    <div>
                                        <span class="block text-gray-500 dark:text-gray-400 font-medium">Location</span>
                                        <span
                                            class="text-gray-900 dark:text-white">{{ $registration->event->location }}</span>
                                    </div>
                                    <div>
                                        <span
                                            class="block text-gray-500 dark:text-gray-400 font-medium">Organizer</span>
                                        <span
                                            class="text-gray-900 dark:text-white">{{ $registration->event->organizer_name }}</span>
                                    </div>
                                </div>
                                @if ($registration->event->refund_policy)
                                    <div class="mb-4">
                                        <span class="block text-gray-500 dark:text-gray-400 font-medium">Refund
                                            Policy</span>
                                        <div
                                            class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                                            <p class="text-blue-800 dark:text-blue-300 text-sm leading-relaxed">
                                                {{ $registration->event->refund_policy }}
                                            </p>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <!-- Booking Details -->
                            <div class="mb-8">
                                <h5 class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-3">Your Booking
                                    Details</h5>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div>
                                        <span class="block text-gray-500 dark:text-gray-400 font-medium">Ticket
                                            Type</span>
                                        <span class="text-gray-900 dark:text-white font-semibold">
                                            {{ $registration->ticket->type }}
                                        </span>
                                    </div>
                                    <div>
                                        <span class="block text-gray-500 dark:text-gray-400 font-medium">Ticket
                                            Price</span>
                                        <span class="text-gray-900 dark:text-white font-semibold">
                                            RM{{ number_format($registration->ticket->price, 2) }}
                                        </span>
                                    </div>
                                    <div>
                                        <span class="block text-gray-500 dark:text-gray-400 font-medium">Registration
                                            Date</span>
                                        <span class="text-gray-900 dark:text-white">
                                            {{ $registration->created_at->format('d M Y') }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Refund Form -->
                            <form action="{{ route('user.refunds.store') }}" method="POST" class="space-y-6">
                                @csrf
                                <input type="hidden" name="ticket_id" value="{{ $ticketId }}">

                                <div>
                                    <label for="refund_reason"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Reason for Refund <span class="text-red-500">*</span>
                                    </label>
                                    <textarea id="refund_reason" name="refund_reason" rows="4"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-blue-400"
                                        placeholder="Please explain why you are requesting a refund..." required>{{ old('refund_reason') }}</textarea>
                                    @error('refund_reason')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="flex flex-col sm:flex-row gap-4 pt-4">
                                    <button type="submit"
                                        class="inline-flex items-center justify-center px-6 py-3 bg-orange-600 hover:bg-orange-700 text-white font-medium rounded-lg transition-colors focus:ring-2 focus:ring-orange-500 focus:ring-offset-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                                        </svg>
                                        Submit Refund Request
                                    </button>
                                    <a href="{{ route('user.events.my-bookings') }}"
                                        class="inline-flex items-center justify-center px-6 py-3 bg-gray-300 hover:bg-gray-400 text-gray-700 font-medium rounded-lg transition-colors focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:bg-gray-600 dark:hover:bg-gray-500 dark:text-white">
                                        Cancel
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                @else
                    <!-- Refund History -->
                    <div class="bg-white dark:bg-gray-800 shadow-lg sm:rounded-xl overflow-hidden">
                        <div class="relative bg-unimasblue dark:bg-unimasblue p-6">
                            <div class="absolute inset-0 opacity-10 bg-pattern-grid"></div>
                            <h1 class="text-2xl sm:text-3xl font-bold text-center text-white">
                                My Refund Requests
                            </h1>
                        </div>
                        <div class="p-4 sm:p-6 md:p-8">
                            <div class="text-right mb-4">
                                <a href="{{ route('user.events.my-bookings') }}"
                                    class="inline-flex items-center justify-center px-5 py-2.5 bg-unimasblue hover:bg-unimasblue text-white text-sm font-medium rounded-lg transition duration-300 shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                    </svg>
                                    Back to My Bookings
                                </a>
                            </div>
                            @if (isset($refunds) && $refunds->count() > 0)
                                <div class="grid gap-6 md:gap-8">
                                    @foreach ($refunds as $refund)
                                        <div
                                            class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl shadow-sm hover:shadow-md transition-shadow duration-300">
                                            <div class="p-6">
                                                <div class="flex flex-col lg:flex-row min-h-[120px]">
                                                    <!-- Left Content -->
                                                    <div class="flex-1">
                                                        <!-- Header with Fixed Status Position -->
                                                        <div class="flex justify-between items-start mb-4">
                                                            <div class="flex-1 pr-4">
                                                                <h3
                                                                    class="text-lg font-semibold text-gray-900 dark:text-white mb-1 truncate">
                                                                    {{ $refund->eventRegistration->event->name ?? 'N/A' }}
                                                                </h3>
                                                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                                                    Refund Request #{{ $refund->id }}
                                                                </p>
                                                            </div>
                                                            <!-- Fixed Width Status Badge -->
                                                            <div class="w-24 flex-shrink-0">
                                                                <span
                                                                    class="px-3 py-1 inline-flex justify-center w-full text-xs leading-5 font-semibold rounded-full
                                                                @if ($refund->status === 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100
                                                                @elseif($refund->status === 'approved') bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100
                                                                @elseif($refund->status === 'rejected') bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100
                                                                @else bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-100 @endif">
                                                                    {{ ucfirst($refund->status) }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <!-- Refund Details Grid -->
                                                        <div
                                                            class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                                                            <div>
                                                                <span
                                                                    class="block text-gray-500 dark:text-gray-400 font-medium">Refund
                                                                    Amount</span>
                                                                <span
                                                                    class="text-gray-900 dark:text-white font-semibold">
                                                                    ${{ number_format($refund->refund_amount, 2) }}
                                                                </span>
                                                            </div>
                                                            <div>
                                                                <span
                                                                    class="block text-gray-500 dark:text-gray-400 font-medium">Request
                                                                    Date</span>
                                                                <span class="text-gray-900 dark:text-white">
                                                                    {{ $refund->created_at->format('M d, Y') }}
                                                                </span>
                                                            </div>
                                                            <div>
                                                                <span
                                                                    class="block text-gray-500 dark:text-gray-400 font-medium">Ticket
                                                                    Type</span>
                                                                <span class="text-gray-900 dark:text-white">
                                                                    {{ $refund->ticket->type ?? 'N/A' }}
                                                                </span>
                                                            </div>
                                                            <div>
                                                                <span
                                                                    class="block text-gray-500 dark:text-gray-400 font-medium">Reason</span>
                                                                <span class="text-gray-900 dark:text-white">
                                                                    {{ Str::limit($refund->refund_reason, 50) }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Right Content - Fixed Width Actions Column -->
                                                    <div class="lg:w-48 flex-shrink-0 lg:ml-6 mt-4 lg:mt-0">
                                                        <div class="flex flex-col gap-2">
                                                            <a href="{{ route('user.events.registration-details', $refund->eventRegistration->id ?? 0) }}"
                                                                class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium rounded-lg text-indigo-600 bg-indigo-50 hover:bg-indigo-100 dark:text-indigo-400 dark:bg-indigo-900/20 dark:hover:bg-indigo-900/30 transition-colors w-full">
                                                                <svg class="h-4 w-4 mr-1.5" fill="none"
                                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round"
                                                                        stroke-linejoin="round" stroke-width="2"
                                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                                    <path stroke-linecap="round"
                                                                        stroke-linejoin="round" stroke-width="2"
                                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                                </svg>
                                                                View Registration
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Reason Section -->
                                                <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                                                    <p
                                                        class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">
                                                        Reason for Refund</p>
                                                    <p class="text-gray-900 dark:text-white text-sm">
                                                        {{ $refund->refund_reason }}</p>
                                                    @if ($refund->notes)
                                                        <p
                                                            class="text-sm font-medium text-gray-500 dark:text-gray-400 mt-3 mb-2">
                                                            Organizer Notes</p>
                                                        <p class="text-gray-900 dark:text-white text-sm">
                                                            {{ $refund->notes }}</p>
                                                    @endif
                                                </div>
                                                <!-- Refund Proof Section - Shown Only for Approved Requests with Proof -->
                                                @if ($refund->status === 'approved' && $refund->refund_proof)
                                                    <div class="mt-3">
                                                        <p
                                                            class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">
                                                            Refund Proof</p>
                                                        @php
                                                            $ext = pathinfo($refund->refund_proof, PATHINFO_EXTENSION);
                                                        @endphp
                                                        @if (in_array($ext, ['jpg', 'jpeg', 'png']))
                                                            <a href="{{ asset('storage/' . $refund->refund_proof) }}"
                                                                target="_blank">
                                                                <img src="{{ asset('storage/' . $refund->refund_proof) }}"
                                                                    alt="Refund Proof"
                                                                    class="max-w-xs rounded border border-gray-300 dark:border-gray-700 shadow">
                                                            </a>
                                                        @elseif($ext === 'pdf')
                                                            <a href="{{ asset('storage/' . $refund->refund_proof) }}"
                                                                target="_blank"
                                                                class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg shadow-sm hover:bg-blue-700 transition">
                                                                <svg class="w-5 h-5" fill="none"
                                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round"
                                                                        stroke-linejoin="round" stroke-width="2"
                                                                        d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                                </svg>
                                                                View PDF
                                                            </a>
                                                        @else
                                                            <a href="{{ asset('storage/' . $refund->refund_proof) }}"
                                                                target="_blank"
                                                                class="text-blue-600 underline">Download Refund
                                                                Proof</a>
                                                        @endif
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="flex flex-col items-center justify-center py-12 text-center">
                                    <div class="text-gray-400 dark:text-gray-500 mb-4">
                                        <svg class="mx-auto h-16 w-16" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </div>
                                    <h3 class="text-gray-600 dark:text-gray-300 text-lg font-medium mb-2">No refund
                                        requests</h3>
                                    <p class="text-gray-500 dark:text-gray-400 mb-6">You haven't made any refund
                                        requests yet.</p>
                                    <a href="{{ route('user.events.my-bookings') }}"
                                        class="inline-flex items-center px-5 py-2.5 bg-unimasblue hover:bg-unimasblue text-white text-sm font-medium rounded-lg transition duration-300 shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                        </svg>
                                        Back to My Bookings
                                    </a>
                                </div>
                            @endif
                        </div>
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
