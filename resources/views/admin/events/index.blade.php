<!-- resources/views/admin/events/index.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Manage Events') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Tabs Navigation -->
                    <div class="mb-4 border-b dark:border-gray-700">
                        <div class="flex space-x-4">
                            <a href="{{ route('admin.events', ['tab' => 'pending']) }}"
                               class="pb-2 px-1 {{ request('tab', 'pending') === 'pending' ? 'border-b-2 border-blue-500 text-blue-600 dark:text-blue-400' : 'text-gray-500 dark:text-gray-400' }}">
                                Pending Approval ({{ $pendingCount }})
                            </a>
                            <a href="{{ route('admin.events', ['tab' => 'processed']) }}"
                               class="pb-2 px-1 {{ request('tab') === 'processed' ? 'border-b-2 border-blue-500 text-blue-600 dark:text-blue-400' : 'text-gray-500 dark:text-gray-400' }}">
                                Processed Events ({{ $processedCount }})
                            </a>
                        </div>
                    </div>

                    <!-- Search Form -->
                    <div class="mb-4">
                        <form method="GET" action="{{ route('admin.events') }}">
                            <input type="hidden" name="tab" value="{{ request('tab', 'pending') }}">
                            <div class="flex gap-2">
                                <input type="text" name="search" placeholder="Search events..."
                                       class="w-full rounded-lg border-gray-300 dark:bg-gray-700 dark:border-gray-600"
                                       value="{{ request('search') }}">
                                <button type="submit"
                                        class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                                    Search
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Events Table -->
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="text-left border-b dark:border-gray-700">
                                    <th class="pb-2">Event Name</th>
                                    <th class="pb-2">Organizer</th>
                                    <th class="pb-2">Date</th>
                                    <th class="pb-2">Status</th>
                                    @if(request('tab', 'pending') === 'pending')
                                    <th class="pb-2">Actions</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($events as $event)
                                <tr class="border-b dark:border-gray-700">
                                    <td class="py-3">
                                        <div class="font-medium">{{ $event->name }}</div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">
                                            {{ $event->location }}
                                        </div>
                                    </td>
                                    <td>{{ $event->organizer->name }}</td>
                                    <td>{{ $event->date ? \Carbon\Carbon::parse($event->date)->format('M d, Y') : 'N/A' }}</td>
                                    <td>
                                        <span class="px-2 py-1 text-xs rounded-full
                                            {{ $event->status === 'pending' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200' :
                                            ($event->status === 'approved' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' :
                                            'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200') }}">
                                            {{ ucfirst($event->status) }}
                                        </span>
                                    </td>
                                    @if(request('tab', 'pending') === 'pending')
                                    <td class="flex gap-2 py-3">
                                        <form method="POST" action="{{ route('admin.events.approve', $event) }}">
                                            @csrf
                                            <button type="submit"
                                                    class="px-3 py-1 bg-green-500 text-white rounded hover:bg-green-600">
                                                Approve
                                            </button>
                                        </form>
                                        <form method="POST" action="{{ route('admin.events.reject', $event) }}">
                                            @csrf
                                            <button type="submit"
                                                    class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600">
                                                Reject
                                            </button>
                                        </form>
                                    </td>
                                    @endif
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="{{ request('tab', 'pending') === 'pending' ? 5 : 4 }}"
                                        class="py-4 text-center text-gray-500 dark:text-gray-400">
                                        No events found
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($events->hasPages())
                    <div class="mt-4">
                        {{ $events->appends(request()->query())->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
