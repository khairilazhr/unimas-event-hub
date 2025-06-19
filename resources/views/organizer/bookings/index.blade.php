<x-app-layout>
    <div class="min-h-screen flex flex-col">
        <main class="flex-grow py-6 sm:py-8 md:py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 shadow-lg sm:rounded-xl overflow-hidden">
                    <div class="relative bg-unimasblue dark:bg-unimasblue p-6">
                        <div class="absolute inset-0 opacity-10 bg-pattern-grid"></div>
                        <h1 class="text-2xl sm:text-3xl font-bold text-center text-white">
                            Manage Event Bookings
                        </h1>
                    </div>
                    <div class="p-4 sm:p-6 md:p-8">
                        @if (session('success'))
                            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                                {{ session('error') }}
                            </div>
                        @endif

                        <!-- Events Filter -->
                        <div class="mb-6">
                            <label for="eventFilter" class="block text-lg font-medium mb-2">Filter by Event:</label>
                            <select id="eventFilter"
                                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-200">
                                <option value="all">All Events</option>
                                @foreach ($events as $event)
                                    <option value="{{ $event->id }}">{{ $event->name }} ({{ $event->date }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Status Filter -->
                        <div class="mb-6">
                            <label for="statusFilter" class="block text-lg font-medium mb-2">Filter by Status:</label>
                            <select id="statusFilter"
                                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-200">
                                <option value="all">All Statuses</option>
                                <option value="pending">Pending</option>
                                <option value="approved">Approved</option>
                                <option value="rejected">Rejected</option>
                            </select>
                        </div>

                        <!-- Report Button -->
                        <div class="flex justify-end mb-4">
                            <form action="{{ route('organizer.bookings.report') }}" method="GET" target="_blank">
                                <button type="submit"
                                    class="inline-flex items-center px-4 py-2 bg-unimasblue text-white text-sm font-medium rounded hover:bg-blue-700 transition">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Generate Report
                                </button>
                            </form>
                        </div>

                        <!-- Bookings Table -->
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th scope="col"
                                            class="px-3 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider w-1/6">
                                            Event
                                        </th>
                                        <th scope="col"
                                            class="px-3 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider w-1/6">
                                            Ticket
                                        </th>
                                        <th scope="col"
                                            class="px-3 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider w-1/6">
                                            Attendee
                                        </th>
                                        <th scope="col"
                                            class="px-3 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider w-1/6">
                                            Contact
                                        </th>
                                        <th scope="col"
                                            class="px-3 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider w-1/6">
                                            Date
                                        </th>
                                        <th scope="col"
                                            class="px-3 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider w-1/12">
                                            Status
                                        </th>
                                        <th scope="col"
                                            class="px-3 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider w-1/12">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700"
                                    id="bookingsTable">
                                    @forelse($registrations as $registration)
                                        <tr class="booking-row" data-event-id="{{ $registration->event->id }}"
                                            data-status="{{ $registration->status }}">
                                            <td class="px-3 py-4">
                                                <div class="text-sm font-medium text-gray-900 dark:text-white truncate">
                                                    {{ $registration->event->name }}</div>
                                                <div class="text-xs text-gray-500 dark:text-gray-400">
                                                    {{ date('M d, Y', strtotime($registration->event->date)) }}</div>
                                            </td>
                                            <td class="px-3 py-4">
                                                <div class="text-sm text-gray-900 dark:text-white">
                                                    {{ $registration->ticket->type }}</div>
                                                <div class="text-xs text-gray-500 dark:text-gray-400">
                                                    {{ $registration->ticket->section }},
                                                    {{ $registration->ticket->row }},
                                                    {{ $registration->ticket->seat }}
                                                </div>
                                            </td>
                                            <td class="px-3 py-4">
                                                <div class="text-sm font-medium text-gray-900 dark:text-white truncate">
                                                    {{ $registration->name }}</div>
                                                @if ($registration->user)
                                                    <div class="text-xs text-gray-500 dark:text-gray-400">ID:
                                                        {{ $registration->user->id }}</div>
                                                @else
                                                    <div class="text-xs text-gray-500 dark:text-gray-400">Guest</div>
                                                @endif
                                            </td>
                                            <td class="px-3 py-4">
                                                <div class="text-sm text-gray-900 dark:text-white truncate">
                                                    {{ $registration->email }}</div>
                                                <div class="text-xs text-gray-500 dark:text-gray-400">
                                                    {{ $registration->phone }}</div>
                                            </td>
                                            <td class="px-3 py-4">
                                                <div class="text-sm text-gray-900 dark:text-white">
                                                    {{ date('M d, Y', strtotime($registration->created_at)) }}</div>
                                                <div class="text-xs text-gray-500 dark:text-gray-400">
                                                    {{ date('h:i A', strtotime($registration->created_at)) }}</div>
                                            </td>
                                            <td class="px-3 py-4">
                                                <span
                                                    class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                                    {{ $registration->status == 'approved'
                                                        ? 'bg-green-100 text-green-800'
                                                        : ($registration->status == 'rejected'
                                                            ? 'bg-red-100 text-red-800'
                                                            : 'bg-yellow-100 text-yellow-800') }}">
                                                    {{ ucfirst($registration->status) }}
                                                </span>
                                            </td>
                                            <td class="px-3 py-4 text-sm font-medium">
                                                <a href="{{ route('organizer.bookings.show', $registration->id) }}"
                                                    class="text-blue-600 hover:text-blue-900 text-xs">
                                                    View
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7"
                                                class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                                No bookings found.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="mt-6">
                            {{ $registrations->links() }}
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const eventFilter = document.getElementById('eventFilter');
            const statusFilter = document.getElementById('statusFilter');
            const bookingRows = document.querySelectorAll('.booking-row');

            // Function to filter the table rows
            function filterBookings() {
                const selectedEventId = eventFilter.value;
                const selectedStatus = statusFilter.value;

                bookingRows.forEach(row => {
                    const rowEventId = row.getAttribute('data-event-id');
                    const rowStatus = row.getAttribute('data-status');

                    const eventMatch = selectedEventId === 'all' || rowEventId === selectedEventId;
                    const statusMatch = selectedStatus === 'all' || rowStatus === selectedStatus;

                    if (eventMatch && statusMatch) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            }

            // Add event listeners to the filters
            eventFilter.addEventListener('change', filterBookings);
            statusFilter.addEventListener('change', filterBookings);
        });
    </script>
</x-app-layout>
