<x-app-layout>
    <div class="flex flex-col min-h-screen bg-gray-100 dark:bg-gray-900">
        <main class="flex-grow py-12">
            <div class="max-w-5xl mx-auto px-6">
                <div class="bg-white dark:bg-gray-800 shadow-md rounded-2xl p-8">
                    <div class="text-center mb-6">
                        <div class="w-14 h-14 mx-auto rounded-full bg-green-100 dark:bg-green-900 flex items-center justify-center mb-4">
                            <svg class="w-8 h-8 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <h1 class="text-2xl font-semibold text-gray-800 dark:text-white">Registration Successful!</h1>
                        <p class="mt-1 text-gray-600 dark:text-gray-300">Thank you for registering for the event.</p>
                    </div>

                    <div class="bg-gray-50 dark:bg-gray-700 rounded-xl p-6">
                        <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Registration Details</h2>
                        
                        @if($registration->user_id)
                            <div class="mb-4">
                                <h3 class="text-sm text-gray-500 dark:text-gray-400">Registered By</h3>
                                <p class="text-lg text-gray-800 dark:text-white">{{ $registration->user->name }}</p>
                            </div>
                        @endif

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div><h3 class="text-sm text-gray-500 dark:text-gray-400">Event</h3><p class="text-lg text-gray-800 dark:text-white">{{ $registration->event->name }}</p></div>
                            <div><h3 class="text-sm text-gray-500 dark:text-gray-400">Date</h3><p class="text-lg text-gray-800 dark:text-white">{{ \Carbon\Carbon::parse($registration->event->date)->format('d M Y') }}</p></div>
                            <div><h3 class="text-sm text-gray-500 dark:text-gray-400">Ticket Type</h3><p class="text-lg text-gray-800 dark:text-white">{{ $registration->ticket->type }}</p></div>
                            <div><h3 class="text-sm text-gray-500 dark:text-gray-400">Price</h3><p class="text-lg text-gray-800 dark:text-white">RM{{ number_format($registration->ticket->price, 2) }}</p></div>
                            <div><h3 class="text-sm text-gray-500 dark:text-gray-400">Name</h3><p class="text-lg text-gray-800 dark:text-white">{{ $registration->name }}</p></div>
                            <div><h3 class="text-sm text-gray-500 dark:text-gray-400">Email</h3><p class="text-lg text-gray-800 dark:text-white">{{ $registration->email }}</p></div>
                        </div>

                        @if($registration->phone)
                            <div class="mt-4">
                                <h3 class="text-sm text-gray-500 dark:text-gray-400">Phone</h3>
                                <p class="text-lg text-gray-800 dark:text-white">{{ $registration->phone }}</p>
                            </div>
                        @endif
                    </div>

                    <div class="text-center mt-6">
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">A confirmation email has been sent to your email address.</p>
                        <div class="flex flex-col sm:flex-row sm:space-x-4 justify-center">
                            <a href="{{ route('user.events') }}" class="px-6 py-3 text-white bg-indigo-600 hover:bg-indigo-700 rounded-md text-sm font-medium">Back to Events</a>
                            <button onclick="window.print()" class="px-6 py-3 text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md text-sm font-medium hover:bg-gray-50 dark:hover:bg-gray-700">Print Confirmation</button>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <footer class="bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 text-center py-4">
            <p class="text-sm text-gray-500 dark:text-gray-400">&copy; {{ date('Y') }} Your Company Name. All rights reserved.</p>
        </footer>
    </div>
</x-app-layout>