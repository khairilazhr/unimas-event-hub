<x-app-layout>
    <div class="flex flex-col min-h-screen bg-gray-50 dark:bg-gray-900">
        <main class="flex-grow py-12 px-4 sm:px-6 lg:px-8">
            <div class="max-w-7xl mx-auto">
                <!-- Page Header -->
                <div class="bg-white dark:bg-gray-800 shadow-lg sm:rounded-xl overflow-hidden mb-8">
                    <div class="bg-unimasblue p-6 sm:p-8">
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                            <div>
                                <h1 class="text-2xl sm:text-3xl font-bold text-white">Attendance History</h1>
                                <p class="text-blue-100 mt-2">View and manage attendance records for your events</p>
                            </div>
                            <div class="flex gap-2">
                                <a href="{{ route('organizer.attendances') }}"
                                    class="inline-flex items-center px-4 py-2 bg-white text-unimasblue font-semibold rounded-lg shadow hover:bg-gray-100 transition-colors">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V6a1 1 0 00-1-1H5a1 1 0 00-1 1v1a1 1 0 001 1zm12 0h2a1 1 0 001-1V6a1 1 0 00-1-1h-2a1 1 0 00-1 1v1a1 1 0 001 1zM5 20h2a1 1 0 001-1v-1a1 1 0 00-1-1H5a1 1 0 00-1 1v1a1 1 0 001 1z" />
                                    </svg>
                                    QR Scanner
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Statistics Cards -->
                    <div class="p-6 sm:p-8">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                            <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl p-6 text-white">
                                <div class="flex items-center">
                                    <div class="p-2 bg-white bg-opacity-20 rounded-lg">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <p class="text-blue-100 text-sm font-medium">Total Registrations</p>
                                        <p class="text-2xl font-bold">{{ $totalRegistrations }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-xl p-6 text-white">
                                <div class="flex items-center">
                                    <div class="p-2 bg-white bg-opacity-20 rounded-lg">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <p class="text-green-100 text-sm font-medium">Attended</p>
                                        <p class="text-2xl font-bold">{{ $attendedCount }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 rounded-xl p-6 text-white">
                                <div class="flex items-center">
                                    <div class="p-2 bg-white bg-opacity-20 rounded-lg">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <p class="text-yellow-100 text-sm font-medium">Not Attended</p>
                                        <p class="text-2xl font-bold">{{ $notAttendedCount }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Filter Section -->
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-xl p-6 mb-8">
                            <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Filter by Event</h2>
                            <form method="GET" action="{{ route('organizer.attendances.history') }}"
                                class="flex flex-col sm:flex-row gap-4">
                                <div class="flex-1">
                                    <select name="event_id"
                                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-unimasblue focus:border-transparent">
                                        <option value="">All Events</option>
                                        @foreach ($events as $event)
                                            <option value="{{ $event->id }}"
                                                {{ $selectedEventId == $event->id ? 'selected' : '' }}>
                                                {{ $event->name }} -
                                                {{ \Carbon\Carbon::parse($event->date)->format('d M Y') }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <button type="submit"
                                    class="px-6 py-2 bg-unimasblue text-white rounded-lg hover:bg-blue-700 transition-colors">
                                    Filter
                                </button>
                                @if ($selectedEventId)
                                    <a href="{{ route('organizer.attendances.history') }}"
                                        class="px-6 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors">
                                        Clear
                                    </a>
                                @endif
                            </form>
                        </div>

                        <!-- Attendance List -->
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden">
                            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                                <h2 class="text-lg font-semibold text-gray-800 dark:text-white">Attendance Records</h2>
                            </div>

                            @if ($registrations->isEmpty())
                                <div class="p-8 text-center">
                                    <div class="text-gray-400 dark:text-gray-500 mb-4">
                                        <svg class="h-16 w-16 mx-auto" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                        </svg>
                                    </div>
                                    <p class="text-gray-600 dark:text-gray-300 text-lg font-medium mb-2">No
                                        registrations found</p>
                                    <p class="text-gray-500 dark:text-gray-400">There are no approved registrations for
                                        the selected criteria.</p>
                                </div>
                            @else
                                <div class="p-6">
                                    <div class="grid gap-4">
                                        @foreach ($registrations as $registration)
                                            <div
                                                class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 border border-gray-200 dark:border-gray-600">
                                                <div
                                                    class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                                                    <!-- Attendee Info -->
                                                    <div class="flex-1">
                                                        <div class="flex items-start justify-between mb-2">
                                                            <div>
                                                                <h3
                                                                    class="text-lg font-semibold text-gray-900 dark:text-white">
                                                                    {{ $registration->name }}
                                                                </h3>
                                                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                                                    {{ $registration->email }}</p>
                                                                @if ($registration->phone)
                                                                    <p class="text-sm text-gray-600 dark:text-gray-400">
                                                                        {{ $registration->phone }}</p>
                                                                @endif
                                                            </div>
                                                            <div class="text-right">
                                                                @if ($registration->attendance && $registration->attendance->status === 'attended')
                                                                    <span
                                                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100">
                                                                        <svg class="w-3 h-3 mr-1" fill="currentColor"
                                                                            viewBox="0 0 20 20">
                                                                            <path fill-rule="evenodd"
                                                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                                                clip-rule="evenodd" />
                                                                        </svg>
                                                                        Attended
                                                                    </span>
                                                                @else
                                                                    <span
                                                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100">
                                                                        <svg class="w-3 h-3 mr-1" fill="currentColor"
                                                                            viewBox="0 0 20 20">
                                                                            <path fill-rule="evenodd"
                                                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                                                                clip-rule="evenodd" />
                                                                        </svg>
                                                                        Not Attended
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        </div>

                                                        <!-- Event & Ticket Info -->
                                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                                            <div>
                                                                <span
                                                                    class="block text-gray-500 dark:text-gray-400 font-medium">Event</span>
                                                                <span
                                                                    class="text-gray-900 dark:text-white font-medium">{{ $registration->event->name }}</span>
                                                                <div class="text-gray-600 dark:text-gray-400">
                                                                    {{ \Carbon\Carbon::parse($registration->event->date)->format('d M Y, h:i A') }}
                                                                </div>
                                                                <div class="text-gray-600 dark:text-gray-400">
                                                                    {{ $registration->event->location }}
                                                                </div>
                                                            </div>
                                                            <div>
                                                                <span
                                                                    class="block text-gray-500 dark:text-gray-400 font-medium">Ticket</span>
                                                                <span
                                                                    class="text-gray-900 dark:text-white font-medium">{{ $registration->ticket->type }}</span>
                                                                <div class="text-gray-600 dark:text-gray-400">
                                                                    Section {{ $registration->ticket->section }}, Row
                                                                    {{ $registration->ticket->row }}, Seat
                                                                    {{ $registration->ticket->seat }}
                                                                </div>
                                                                <div class="text-gray-600 dark:text-gray-400">
                                                                    Registered:
                                                                    {{ \Carbon\Carbon::parse($registration->created_at)->format('d M Y, h:i A') }}
                                                                </div>
                                                                @if (
                                                                    $registration->attendance &&
                                                                        $registration->attendance->status === 'attended' &&
                                                                        $registration->attendance->attended_at)
                                                                    <div class="text-gray-600 dark:text-gray-400">
                                                                        Attended:
                                                                        {{ \Carbon\Carbon::parse($registration->attendance->attended_at)->format('d M Y, h:i A') }}
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Action Button -->
                                                    <div class="flex-shrink-0">
                                                        @if (!$registration->attendance || $registration->attendance->status !== 'attended')
                                                            <button onclick="markAttendance({{ $registration->id }})"
                                                                class="w-full lg:w-auto px-4 py-2 bg-unimasblue text-white rounded-lg hover:bg-blue-700 transition-colors text-sm font-medium"
                                                                data-registration-id="{{ $registration->id }}">
                                                                Mark Attendance
                                                            </button>
                                                        @else
                                                            <span
                                                                class="text-gray-400 dark:text-gray-500 text-sm">Already
                                                                attended</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Pagination -->
                                <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                                    {{ $registrations->links() }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        function markAttendance(registrationId) {
            if (confirm('Are you sure you want to mark this person as attended?')) {
                fetch(`/mark-attendance/${registrationId}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            registration_id: registrationId
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Reload the page to show updated status
                            window.location.reload();
                        } else {
                            alert(data.message || 'Failed to mark attendance');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Failed to mark attendance');
                    });
            }
        }
    </script>

    <meta name="csrf-token" content="{{ csrf_token() }}">
</x-app-layout>
