<x-app-layout>
    <div class="min-h-screen flex flex-col">
        <main class="flex-grow py-6 sm:py-8 md:py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 shadow-lg sm:rounded-xl overflow-hidden">
                    <!-- Header Section -->
                    <div class="relative bg-unimasblue dark:bg-unimasblue p-6">
                        <div class="absolute inset-0 opacity-10 bg-pattern-grid"></div>
                        <div class="relative z-10 flex items-center justify-between">
                            <h1 class="text-2xl sm:text-3xl font-bold text-white">
                                Event Details
                            </h1>
                            <a href="{{ route('admin.events') }}"
                                class="inline-flex items-center px-4 py-2 bg-white/20 hover:bg-white/30 text-white text-sm font-medium rounded-lg transition duration-300 shadow-md hover:shadow-lg">
                                ← Back to Events
                            </a>
                        </div>
                    </div>

                    <!-- Content Section -->
                    <div class="p-4 sm:p-6 md:p-8">
                        <!-- Status & Actions Banner -->
                        <div class="mb-6 p-4 rounded-lg bg-gray-50 dark:bg-gray-700">
                            <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                                <div class="flex items-center gap-2">
                                    <span class="text-lg font-semibold">Status:</span>
                                    <span
                                        class="px-3 py-1 rounded-full text-sm font-medium
                                        {{ $event->status === 'approved'
                                            ? 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100'
                                            : ($event->status === 'pending'
                                                ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100'
                                                : 'bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100') }}">
                                        {{ ucfirst($event->status) }}
                                    </span>
                                </div>
                                @if ($event->status === 'pending')
                                    <div class="flex gap-2">
                                        <form method="POST" action="{{ route('admin.events.approve', $event) }}">
                                            @csrf
                                            <button type="submit"
                                                class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition duration-300 shadow-md hover:shadow-lg">
                                                Approve Event
                                            </button>
                                        </form>
                                        <form method="POST" action="{{ route('admin.events.reject', $event) }}">
                                            @csrf
                                            <button type="submit"
                                                class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition duration-300 shadow-md hover:shadow-lg">
                                                Reject Event
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Main Content Grid -->
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <!-- Event Details Column -->
                            <div class="space-y-6">
                                <!-- Basic Information Card -->
                                <div class="bg-white dark:bg-gray-700 p-6 rounded-xl shadow-sm">
                                    <h2 class="text-xl font-semibold mb-4 text-gray-900 dark:text-white">Event
                                        Information</h2>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <dt class="text-sm text-gray-500 dark:text-gray-400">Event Name</dt>
                                            <dd class="mt-1 text-gray-900 dark:text-white">{{ $event->name }}</dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm text-gray-500 dark:text-gray-400">Date & Time</dt>
                                            <dd class="mt-1 text-gray-900 dark:text-white">
                                                {{ optional($event->date)->format('F j, Y \a\t g:i A') ?? 'Date not available' }}
                                            </dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm text-gray-500 dark:text-gray-400">Location</dt>
                                            <dd class="mt-1 text-gray-900 dark:text-white">{{ $event->location }}</dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm text-gray-500 dark:text-gray-400">Organizer Name</dt>
                                            <dd class="mt-1 text-gray-900 dark:text-white">{{ $event->organizer_name }}
                                            </dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm text-gray-500 dark:text-gray-400">Organizer Account</dt>
                                            <dd class="mt-1 text-gray-900 dark:text-white">
                                                {{ $event->organizer->name }}
                                                <span
                                                    class="text-gray-500 dark:text-gray-400 text-sm">({{ $event->organizer->email }})</span>
                                            </dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm text-gray-500 dark:text-gray-400">Created</dt>
                                            <dd class="mt-1 text-gray-900 dark:text-white">
                                                {{ $event->created_at->format('F j, Y \a\t g:i A') }}</dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm text-gray-500 dark:text-gray-400">Last Updated</dt>
                                            <dd class="mt-1 text-gray-900 dark:text-white">
                                                {{ $event->updated_at->format('F j, Y \a\t g:i A') }}</dd>
                                        </div>
                                    </div>
                                </div>

                                <!-- Description Card -->
                                <div class="bg-white dark:bg-gray-700 p-6 rounded-xl shadow-sm">
                                    <h2 class="text-xl font-semibold mb-4 text-gray-900 dark:text-white">Description
                                    </h2>
                                    <p class="text-gray-700 dark:text-gray-300 whitespace-pre-wrap">
                                        {{ $event->description }}</p>
                                </div>

                                <!-- Payment & Refund Information Card -->
                                @if ($event->payment_details || $event->refund_type || $event->refund_policy)
                                    <div class="bg-white dark:bg-gray-700 p-6 rounded-xl shadow-sm">
                                        <h2 class="text-xl font-semibold mb-4 text-gray-900 dark:text-white">Payment &
                                            Refund Information</h2>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            @if ($event->payment_details)
                                                <div>
                                                    <dt class="text-sm text-gray-500 dark:text-gray-400">Payment Details
                                                    </dt>
                                                    <dd class="mt-1 text-gray-900 dark:text-white whitespace-pre-wrap">
                                                        {{ $event->payment_details }}</dd>
                                                </div>
                                            @endif
                                            @if ($event->refund_type)
                                                <div>
                                                    <dt class="text-sm text-gray-500 dark:text-gray-400">Refund Type
                                                    </dt>
                                                    <dd class="mt-1 text-gray-900 dark:text-white">
                                                        {{ $event->refund_type }}</dd>
                                                </div>
                                            @endif
                                            @if ($event->refund_policy)
                                                <div class="md:col-span-2">
                                                    <dt class="text-sm text-gray-500 dark:text-gray-400">Refund Policy
                                                    </dt>
                                                    <dd class="mt-1 text-gray-900 dark:text-white whitespace-pre-wrap">
                                                        {{ $event->refund_policy }}</dd>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endif

                                <!-- Supporting Documents Card -->
                                @if ($event->supporting_docs)
                                    <div class="bg-white dark:bg-gray-700 p-6 rounded-xl shadow-sm">
                                        <h2 class="text-xl font-semibold mb-4 text-gray-900 dark:text-white">Supporting
                                            Documents</h2>
                                        <div class="flex items-center space-x-2">
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                                </path>
                                            </svg>
                                            <a href="{{ Storage::url($event->supporting_docs) }}" target="_blank"
                                                class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                                View Supporting Documents
                                            </a>
                                        </div>
                                    </div>
                                @endif

                                <!-- QR Code Card -->
                                @if ($event->qr_code)
                                    <div class="bg-white dark:bg-gray-700 p-6 rounded-xl shadow-sm">
                                        <h2 class="text-xl font-semibold mb-4 text-gray-900 dark:text-white">QR Code
                                        </h2>
                                        <div class="aspect-square w-32 mx-auto rounded-lg overflow-hidden">
                                            <img src="{{ Storage::url($event->qr_code) }}" alt="Event QR Code"
                                                class="w-full h-full object-cover">
                                        </div>
                                    </div>
                                @endif

                                <!-- Poster Card -->
                                @if ($event->poster)
                                    <div class="bg-white dark:bg-gray-700 p-6 rounded-xl shadow-sm">
                                        <h2 class="text-xl font-semibold mb-4 text-gray-900 dark:text-white">Event
                                            Poster</h2>
                                        <div class="aspect-[3/2] rounded-lg overflow-hidden">
                                            <img src="{{ Storage::url($event->poster) }}" alt="Event poster"
                                                class="w-full h-full object-cover">
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <!-- Statistics Column -->
                            <div class="space-y-6">
                                <!-- Statistics Card -->
                                <div class="bg-white dark:bg-gray-700 p-6 rounded-xl shadow-sm">
                                    <h2 class="text-xl font-semibold mb-4 text-gray-900 dark:text-white">Event
                                        Statistics</h2>
                                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                        <div class="text-center p-4 bg-gray-50 dark:bg-gray-600 rounded-lg">
                                            <dt class="text-sm text-gray-500 dark:text-gray-400">Total Tickets</dt>
                                            <dd class="mt-1 text-2xl font-bold text-gray-900 dark:text-white">
                                                {{ $event->tickets->count() }}
                                            </dd>
                                        </div>
                                        <div class="text-center p-4 bg-gray-50 dark:bg-gray-600 rounded-lg">
                                            <dt class="text-sm text-gray-500 dark:text-gray-400">Registrations</dt>
                                            <dd class="mt-1 text-2xl font-bold text-gray-900 dark:text-white">
                                                {{ $event->registrations->count() }}
                                            </dd>
                                        </div>
                                        <div class="text-center p-4 bg-gray-50 dark:bg-gray-600 rounded-lg">
                                            <dt class="text-sm text-gray-500 dark:text-gray-400">Forum Topics</dt>
                                            <dd class="mt-1 text-2xl font-bold text-gray-900 dark:text-white">
                                                {{ $event->forumTopics->count() }}
                                            </dd>
                                        </div>
                                        <div class="text-center p-4 bg-gray-50 dark:bg-gray-600 rounded-lg">
                                            <dt class="text-sm text-gray-500 dark:text-gray-400">Questionnaires</dt>
                                            <dd class="mt-1 text-2xl font-bold text-gray-900 dark:text-white">
                                                {{ $event->questionnaires->count() }}
                                            </dd>
                                        </div>
                                        <div class="text-center p-4 bg-gray-50 dark:bg-gray-600 rounded-lg">
                                            <dt class="text-sm text-gray-500 dark:text-gray-400">Refund Requests</dt>
                                            <dd class="mt-1 text-2xl font-bold text-gray-900 dark:text-white">
                                                {{ $event->tickets->flatMap->refunds->count() }}
                                            </dd>
                                        </div>
                                        <div class="text-center p-4 bg-gray-50 dark:bg-gray-600 rounded-lg">
                                            <dt class="text-sm text-gray-500 dark:text-gray-400">Total Revenue</dt>
                                            <dd class="mt-1 text-2xl font-bold text-gray-900 dark:text-white">
                                                RM{{ number_format($event->registrations->sum('amount_paid'), 2) }}
                                            </dd>
                                        </div>
                                    </div>
                                </div>

                                <!-- Tickets Information Card -->
                                <div class="bg-white dark:bg-gray-700 p-6 rounded-xl shadow-sm">
                                    <h2 class="text-xl font-semibold mb-4 text-gray-900 dark:text-white">Tickets
                                        Information</h2>
                                    <div class="space-y-4">
                                        @forelse($groupedTickets as $ticketGroup)
                                            <div class="border border-gray-200 dark:border-gray-600 rounded-lg p-4">
                                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                                    <div>
                                                        <dt class="text-sm text-gray-500 dark:text-gray-400">Type</dt>
                                                        <dd class="mt-1 text-gray-900 dark:text-white font-medium">
                                                            {{ $ticketGroup['type'] }}</dd>
                                                    </div>
                                                    <div>
                                                        <dt class="text-sm text-gray-500 dark:text-gray-400">Price</dt>
                                                        <dd class="mt-1 text-gray-900 dark:text-white font-medium">
                                                            RM{{ number_format($ticketGroup['price'], 2) }}</dd>
                                                    </div>
                                                    <div>
                                                        <dt class="text-sm text-gray-500 dark:text-gray-400">Available
                                                        </dt>
                                                        <dd class="mt-1 text-gray-900 dark:text-white">
                                                            {{ $ticketGroup['count'] }} tickets</dd>
                                                    </div>
                                                </div>
                                                @if ($ticketGroup['description'])
                                                    <div class="mt-3">
                                                        <dt class="text-sm text-gray-500 dark:text-gray-400">
                                                            Description</dt>
                                                        <dd class="mt-1 text-gray-900 dark:text-white text-sm">
                                                            {{ $ticketGroup['description'] }}</dd>
                                                    </div>
                                                @endif
                                                @if (!empty($ticketGroup['sections']))
                                                    <div class="mt-3">
                                                        <dt class="text-sm text-gray-500 dark:text-gray-400">
                                                            Sections</dt>
                                                        <dd class="mt-1 text-gray-900 dark:text-white text-sm">
                                                            {{ implode(', ', $ticketGroup['sections']) }}</dd>
                                                    </div>
                                                @endif
                                                <div class="mt-3 flex justify-between items-center">
                                                    <span class="text-sm text-gray-500 dark:text-gray-400">
                                                        Registrations: {{ $ticketGroup['total_registrations'] }}
                                                    </span>
                                                    <span class="text-sm text-gray-500 dark:text-gray-400">
                                                        Refunds: {{ $ticketGroup['total_refunds'] }}
                                                    </span>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="text-center text-gray-500 dark:text-gray-400 py-4">
                                                No tickets available for this event
                                            </div>
                                        @endforelse
                                    </div>
                                </div>

                                <!-- Recent Registrations Card -->
                                <div class="bg-white dark:bg-gray-700 p-6 rounded-xl shadow-sm">
                                    <h2 class="text-xl font-semibold mb-4 text-gray-900 dark:text-white">Recent
                                        Registrations</h2>
                                    <div class="space-y-3">
                                        @forelse($event->registrations->take(5) as $registration)
                                            <div
                                                class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-600 rounded-lg">
                                                <div>
                                                    <p class="font-medium text-gray-900 dark:text-white">
                                                        {{ $registration->user->name }}</p>
                                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                                        {{ $registration->created_at->diffForHumans() }}
                                                    </p>
                                                </div>
                                                <span
                                                    class="px-2 py-1 text-sm rounded-full
                                                {{ $registration->status === 'confirmed'
                                                    ? 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100'
                                                    : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100' }}">
                                                    {{ ucfirst($registration->status) }}
                                                </span>
                                            </div>
                                        @empty
                                            <div class="p-4 text-center text-gray-500 dark:text-gray-400">
                                                No registrations yet
                                            </div>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
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
</x-app-layout>
