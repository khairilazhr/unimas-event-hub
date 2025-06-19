<x-app-layout>
    <div class="flex flex-col min-h-screen bg-gray-100 dark:bg-gray-900">
        <main class="flex-grow py-12">
            <div class="max-w-5xl mx-auto px-6">
                <div class="bg-white dark:bg-gray-800 shadow-md rounded-2xl p-8">
                    <div class="text-center mb-6">
                        <div
                            class="w-14 h-14 mx-auto rounded-full bg-green-100 dark:bg-green-900 flex items-center justify-center mb-4">
                            <svg class="w-8 h-8 text-green-600 dark:text-green-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <h1 class="text-2xl font-semibold text-gray-800 dark:text-white">
                            @if ($registration->status === 'pending')
                                Registration Submitted!
                            @else
                                Registration Successful!
                            @endif
                        </h1>
                        <p class="mt-1 text-gray-600 dark:text-gray-300">
                            @if ($registration->status === 'pending')
                                Your registration is pending organizer approval. Please wait while we verify your
                                payment.
                            @else
                                Thank you for registering for the event.
                            @endif
                        </p>
                    </div>

                    <div class="bg-gray-50 dark:bg-gray-700 rounded-xl p-6">
                        <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Registration Details</h2>

                        <!-- Added Reference Number -->
                        @if ($registration->payment)
                            <div class="mb-4 bg-blue-50 dark:bg-blue-900/20 p-4 rounded-lg">
                                <div class="flex items-center gap-3">
                                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 flex-shrink-0" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                        </path>
                                    </svg>
                                    <div>
                                        <h3 class="text-sm font-medium text-blue-800 dark:text-blue-200">Payment
                                            Reference</h3>
                                        <p class="mt-1 text-lg font-semibold text-blue-600 dark:text-blue-300">
                                            {{ $registration->payment->ref_no }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if ($registration->user_id)
                            <div class="mb-4">
                                <h3 class="text-sm text-gray-500 dark:text-gray-400">Registered By</h3>
                                <p class="text-lg text-gray-800 dark:text-white">{{ $registration->user->name }}</p>
                            </div>
                        @endif

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <h3 class="text-sm text-gray-500 dark:text-gray-400">Event</h3>
                                <p class="text-lg text-gray-800 dark:text-white">{{ $registration->event->name }}</p>
                            </div>
                            <div>
                                <h3 class="text-sm text-gray-500 dark:text-gray-400">Date</h3>
                                <p class="text-lg text-gray-800 dark:text-white">
                                    {{ \Carbon\Carbon::parse($registration->event->date)->format('d M Y') }}</p>
                            </div>
                            <div>
                                <h3 class="text-sm text-gray-500 dark:text-gray-400">Ticket Type</h3>
                                <p class="text-lg text-gray-800 dark:text-white">{{ $registration->ticket->type }}</p>
                            </div>
                            <div>
                                <h3 class="text-sm text-gray-500 dark:text-gray-400">Price</h3>
                                <p class="text-lg text-gray-800 dark:text-white">
                                    RM{{ number_format($registration->ticket->price, 2) }}</p>
                            </div>
                            <div>
                                <h3 class="text-sm text-gray-500 dark:text-gray-400">Name</h3>
                                <p class="text-lg text-gray-800 dark:text-white">{{ $registration->name }}</p>
                            </div>
                            <div>
                                <h3 class="text-sm text-gray-500 dark:text-gray-400">Email</h3>
                                <p class="text-lg text-gray-800 dark:text-white">{{ $registration->email }}</p>
                            </div>
                            <!-- Added Status Display -->
                            <div>
                                <h3 class="text-sm text-gray-500 dark:text-gray-400">Status</h3>
                                <p
                                    class="text-lg font-medium 
                                    @if ($registration->status === 'pending') text-yellow-600 dark:text-yellow-400
                                    @elseif($registration->status === 'confirmed') text-green-600 dark:text-green-400
                                    @else text-gray-800 dark:text-white @endif">
                                    {{ ucfirst($registration->status) }}
                                </p>
                            </div>
                        </div>

                        @if ($registration->phone)
                            <div class="mt-4">
                                <h3 class="text-sm text-gray-500 dark:text-gray-400">Phone</h3>
                                <p class="text-lg text-gray-800 dark:text-white">{{ $registration->phone }}</p>
                            </div>
                        @endif
                    </div>

                    <div class="text-center mt-6">
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                            @if ($registration->status === 'pending')
                                Your receipt has been received. We will notify you via email once approved.
                            @else
                                A confirmation email has been sent to your email address.
                            @endif
                        </p>
                        <div class="flex flex-col sm:flex-row sm:space-x-4 justify-center">
                            <a href="{{ route('user.events') }}"
                                class="px-6 py-3 text-white bg-indigo-600 hover:bg-indigo-700 rounded-md text-sm font-medium">Back
                                to Events</a>
                            <button onclick="window.print()"
                                class="mt-2 sm:mt-0 px-6 py-3 text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md text-sm font-medium hover:bg-gray-50 dark:hover:bg-gray-700">Print
                                Confirmation</button>
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
    <style>
        @media print {

            /* Reset layout for printing */
            body {
                width: 100% !important;
                margin: 0 !important;
                padding: 10px !important;
                background: white !important;
                color: black !important;
            }

            /* Hide unnecessary elements */
            footer,
            .print-button,
            .navigation-header,
            [x-app-layout]>div:not([main]) {
                display: none !important;
            }

            /* Force single column layout */
            .grid {
                grid-template-columns: 1fr !important;
            }

            /* Prevent content splitting */
            .rounded-2xl {
                page-break-inside: avoid;
                break-inside: avoid;
                box-shadow: none !important;
                border: 1px solid #ddd !important;
            }

            /* Adjust padding and margins */
            .p-8,
            .p-6 {
                padding: 15px !important;
            }

            .mb-4,
            .mb-6 {
                margin-bottom: 8px !important;
            }

            /* Dark mode overrides */
            .dark\:bg-gray-800,
            .bg-gray-50 {
                background: white !important;
                color: black !important;
            }

            /* Force full width */
            .max-w-5xl {
                max-width: 100% !important;
                width: 100% !important;
            }

            /* Adjust font sizes */
            .text-2xl {
                font-size: 18px !important;
            }

            .text-lg {
                font-size: 14px !important;
            }

            .text-sm {
                font-size: 12px !important;
            }
        }
    </style>
</x-app-layout>
