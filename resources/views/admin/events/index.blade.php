<x-app-layout>
    <div class="min-h-screen flex flex-col">
        <main class="flex-grow py-6 sm:py-8 md:py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 shadow-lg sm:rounded-xl overflow-hidden">
                    <!-- Header Section -->
                    <div class="relative bg-unimasblue dark:bg-unimasblue p-6">
                        <div class="absolute inset-0 opacity-10 bg-pattern-grid"></div>
                        <h1 class="text-2xl sm:text-3xl font-bold text-center text-white">
                            Manage Events
                        </h1>
                    </div>

                    <!-- Content Section -->
                    <div class="p-4 sm:p-6 md:p-8">
                        <!-- Search and Filters -->
                        <div class="mb-6 flex flex-col sm:flex-row justify-between gap-4">
                            <form method="GET" action="{{ route('admin.events') }}" class="flex-1">
                                <div class="flex gap-2">
                                    <input type="text" name="search" placeholder="Search events..."
                                        class="w-full rounded-lg border-gray-300 dark:bg-gray-700 dark:border-gray-600"
                                        value="{{ request('search') }}">
                                    <button type="submit"
                                        class="px-4 py-2 bg-unimasblue hover:bg-blue-700 text-white rounded-lg transition duration-300 shadow-md hover:shadow-lg">
                                        Search
                                    </button>
                                </div>
                            </form>
                            <div class="flex gap-2">
                                <a href="{{ route('admin.events', ['tab' => 'pending']) }}"
                                    class="px-4 py-2 rounded-lg {{ request('tab', 'pending') === 'pending' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200' : 'bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200' }}">
                                    Pending ({{ $pendingCount }})
                                </a>
                                <a href="{{ route('admin.events', ['tab' => 'processed']) }}"
                                    class="px-4 py-2 rounded-lg {{ request('tab') === 'processed' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200' : 'bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200' }}">
                                    Processed ({{ $processedCount }})
                                </a>
                            </div>
                        </div>

                        @if ($events->isEmpty())
                            <!-- Empty State -->
                            <div class="flex flex-col items-center justify-center py-12 text-center">
                                <div class="text-gray-400 dark:text-gray-500 mb-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                </div>
                                <p class="text-gray-600 dark:text-gray-300 text-lg font-medium mb-2">
                                    No events found
                                </p>
                            </div>
                        @else
                            <!-- Events Table -->
                            <div class="overflow-hidden rounded-xl border border-gray-200 dark:border-gray-700">
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                        <thead class="bg-gray-50 dark:bg-gray-700">
                                            <tr>
                                                <th
                                                    class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                                                    Event Name</th>
                                                <th
                                                    class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase hidden md:table-cell">
                                                    Organizer</th>
                                                <th
                                                    class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                                                    Date</th>
                                                <th
                                                    class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                                                    Status</th>
                                                <th
                                                    class="px-4 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                                                    Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody
                                            class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                            @foreach ($events as $event)
                                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-750 transition-colors">
                                                    <!-- Event Name -->
                                                    <td class="px-4 py-4">
                                                        <a href="{{ route('admin.events.show', $event) }}"
                                                            class="font-medium text-blue-600 dark:text-blue-400 hover:underline">
                                                            {{ $event->name }}
                                                        </a>
                                                    </td>

                                                    <!-- Organizer -->
                                                    <td class="px-4 py-4 hidden md:table-cell">
                                                        <div class="text-sm text-gray-900 dark:text-white">
                                                            {{ $event->organizer->name }}
                                                        </div>
                                                    </td>

                                                    <!-- Date -->
                                                    <td class="px-4 py-4">
                                                        <div class="text-sm text-gray-900 dark:text-white">
                                                            {{ \Carbon\Carbon::parse($event->date)->format('M d, Y') }}
                                                        </div>
                                                    </td>

                                                    <!-- Status -->
                                                    <td class="px-4 py-4">
                                                        <span
                                                            class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                                            @if ($event->status === 'approved') bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100
                                                            @elseif($event->status === 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100
                                                            @else bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100 @endif">
                                                            {{ ucfirst($event->status) }}
                                                        </span>
                                                    </td>

                                                    <!-- Actions -->
                                                    <td class="px-4 py-4 text-right">
                                                        <div class="flex justify-end gap-2">
                                                            @if ($event->status === 'pending')
                                                                <form method="POST"
                                                                    action="{{ route('admin.events.approve', $event) }}">
                                                                    @csrf
                                                                    <button type="submit"
                                                                        class="px-3 py-1.5 bg-green-100 text-green-800 hover:bg-green-200 dark:bg-green-800 dark:text-green-100 dark:hover:bg-green-700 rounded-md text-sm font-medium transition-colors">
                                                                        Approve
                                                                    </button>
                                                                </form>
                                                                <form method="POST"
                                                                    action="{{ route('admin.events.reject', $event) }}">
                                                                    @csrf
                                                                    <button type="submit"
                                                                        class="px-3 py-1.5 bg-red-100 text-red-800 hover:bg-red-200 dark:bg-red-800 dark:text-red-100 dark:hover:bg-red-700 rounded-md text-sm font-medium transition-colors">
                                                                        Reject
                                                                    </button>
                                                                </form>
                                                            @endif
                                                            <a href="{{ route('admin.events.show', $event) }}"
                                                                class="px-3 py-1.5 bg-blue-100 text-blue-800 hover:bg-blue-200 dark:bg-blue-800 dark:text-blue-100 dark:hover:bg-blue-700 rounded-md text-sm font-medium transition-colors">
                                                                View
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Pagination -->
                            @if ($events->hasPages())
                                <div class="mt-4">
                                    {{ $events->appends(request()->query())->links() }}
                                </div>
                            @endif
                        @endif
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
<style>
    .bg-pattern-grid {
        background-image: url('/images/grid-pattern.png');
        background-size: cover;
        background-position: center;
    }
</style>
