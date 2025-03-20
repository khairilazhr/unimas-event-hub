<x-app-layout>
    <div class="flex flex-col min-h-screen bg-gray-100 dark:bg-gray-900">
        {{-- Main Content --}}
        <main class="flex-grow py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 shadow-md sm:rounded-2xl p-8 sm:p-10">
                    <h1 class="text-3xl font-bold text-center text-gray-800 dark:text-white mb-10">
                        My Bookings
                    </h1>

                    @if($registrations->isEmpty())
                        <div class="text-center text-gray-600 dark:text-gray-400 py-8">
                            <p>You don't have any bookings yet.</p>
                            <a href="{{ route('user.events.index') }}" class="inline-block mt-4 px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                                Browse Events
                            </a>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white dark:bg-gray-800 rounded-lg overflow-hidden">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Event
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Date
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Ticket
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Seat
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Price
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Status
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach($registrations as $registration)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                    {{ $registration->event->name }}
                                                </div>
                                                <div class="text-sm text-gray-500 dark:text-gray-400">
                                                    {{ $registration->event->location }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900 dark:text-white">
                                                    {{ \Carbon\Carbon::parse($registration->event->date)->format('d M Y') }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900 dark:text-white">
                                                    {{ $registration->ticket->type }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900 dark:text-white">
                                                    {{ $registration->ticket->section }} - Row {{ $registration->ticket->row }} - Seat {{ $registration->ticket->seat }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900 dark:text-white">
                                                    RM{{ number_format($registration->ticket->price, 2) }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
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
                                                    {{ ucfirst($registration->status ?? 'unknown') }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <a href="{{ route('user.events.registration-details', $registration->id) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">
                                                    View
                                                </a>
                                                
                                                @if($registration->status == 'pending')
                                                    <a href="{{ route('user.events.payment', $registration->id) }}" class="ml-3 text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-300">
                                                        Pay Now
                                                    </a>
                                                @endif
                                                
                                                @if($registration->status != 'cancelled' && \Carbon\Carbon::parse($registration->event->date)->isFuture())
                                                    <form method="POST" action="{{ route('user.events.cancel-registration', $registration->id) }}" class="inline ml-3">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300" onclick="return confirm('Are you sure you want to cancel this booking?')">
                                                            Cancel
                                                        </button>
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </main>

        {{-- Sticky Footer --}}
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