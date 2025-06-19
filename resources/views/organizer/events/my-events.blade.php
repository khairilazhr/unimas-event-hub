<x-app-layout>
    <div class="min-h-screen flex flex-col">
        <main class="flex-grow py-6 sm:py-8 md:py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 shadow-lg sm:rounded-xl overflow-hidden">
                    <div class="relative bg-unimasblue dark:bg-unimasblue p-6">
                        <div class="absolute inset-0 opacity-10 bg-pattern-grid"></div>
                        <h1 class="text-2xl sm:text-3xl font-bold text-center text-white">
                            My Events
                        </h1>
                    </div>

                    <div class="p-4 sm:p-6 md:p-8">
                        <div class="mb-6 flex justify-end">
                            <a href="{{ route('organizer.create.event') }}"
                                class="inline-flex items-center px-5 py-2.5 bg-unimasblue hover:bg-unimasblue text-white text-sm font-medium rounded-lg transition duration-300 shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                                <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                                Create Event
                            </a>
                        </div>

                        @if ($events->isEmpty())
                            <div class="flex flex-col items-center justify-center py-12 text-center">
                                <div class="text-gray-400 dark:text-gray-500 mb-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                </div>
                                <p class="text-gray-600 dark:text-gray-300 text-lg font-medium mb-2">
                                    You don't have any events yet
                                </p>
                                <p class="text-gray-500 dark:text-gray-400 mb-6">
                                    Create exciting events now!
                                </p>
                            </div>
                        @else
                            <div class="overflow-hidden rounded-xl border border-gray-200 dark:border-gray-700">
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 table-fixed">
                                        <thead class="bg-gray-50 dark:bg-gray-700">
                                            <tr>
                                                <th
                                                    class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider w-1/4 sm:w-auto">
                                                    Name</th>
                                                <th
                                                    class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider hidden sm:table-cell w-1/2">
                                                    Description</th>
                                                <th
                                                    class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider hidden md:table-cell w-1/5">
                                                    Status</th>
                                                <th
                                                    class="px-3 sm:px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider w-1/4 sm:w-auto">
                                                    Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody
                                            class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                            @foreach ($events as $event)
                                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-750">
                                                    <td class="px-3 sm:px-6 py-4">
                                                        <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                            {{ $event->name }}
                                                        </div>
                                                    </td>
                                                    <td class="px-3 sm:px-6 py-4 hidden sm:table-cell">
                                                        <div class="text-sm text-gray-900 dark:text-white break-words">
                                                            {{ $event->description }}
                                                        </div>
                                                    </td>
                                                    <td class="px-3 sm:px-6 py-4 hidden md:table-cell align-top">
                                                        <span
                                                            class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                                            @if ($event->status == 'approved') bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100
                                                            @elseif($event->status == 'pending')
                                                                bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100
                                                            @elseif($event->status == 'cancelled')
                                                                bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100
                                                            @else
                                                                bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-100 @endif
                                                        ">
                                                            {{ ucfirst($event->status ?? 'unknown') }}
                                                        </span>
                                                    </td>
                                                    <td
                                                        class="px-3 sm:px-6 py-4 text-right text-sm font-medium align-top">
                                                        <div class="flex flex-col sm:flex-row sm:justify-end gap-1.5">
                                                            <a href="{{ route('organizer.view.event', $event->id) }}"
                                                                class="inline-flex items-center justify-center w-16 px-2 py-1.5 text-xs font-medium rounded border border-blue-200 bg-blue-50 text-blue-700 hover:bg-blue-100 dark:bg-blue-900/20 dark:text-blue-300 dark:border-blue-700 dark:hover:bg-blue-900/30 transition-colors">
                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                    class="h-3 w-3 mr-1" fill="none"
                                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2"
                                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2"
                                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                                </svg>
                                                                View
                                                            </a>

                                                            @if ($event->status === 'pending')
                                                                <a href="{{ route('organizer.edit.event', $event->id) }}"
                                                                    class="inline-flex items-center justify-center w-16 px-2 py-1.5 text-xs font-medium rounded border border-green-200 bg-green-50 text-green-700 hover:bg-green-100 dark:bg-green-900/20 dark:text-green-300 dark:border-green-700 dark:hover:bg-green-900/30 transition-colors">
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                        class="h-3 w-3 mr-1" fill="none"
                                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                                        <path stroke-linecap="round"
                                                                            stroke-linejoin="round" stroke-width="2"
                                                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                                    </svg>
                                                                    Edit
                                                                </a>
                                                            @endif

                                                            @if ($event->status === 'pending')
                                                                <form method="POST"
                                                                    action="{{ route('organizer.cancel.event', $event->id) }}"
                                                                    class="inline">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit"
                                                                        onclick="return confirm('Are you sure you want to cancel this event?')"
                                                                        class="inline-flex items-center justify-center w-16 px-2 py-1.5 text-xs font-medium rounded border border-red-200 bg-red-50 text-red-700 hover:bg-red-100 dark:bg-red-900/20 dark:text-red-300 dark:border-red-700 dark:hover:bg-red-900/30 transition-colors">
                                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                                            class="h-3 w-3 mr-1" fill="none"
                                                                            viewBox="0 0 24 24" stroke="currentColor">
                                                                            <path stroke-linecap="round"
                                                                                stroke-linejoin="round" stroke-width="2"
                                                                                d="M6 18L18 6M6 6l12 12" />
                                                                        </svg>
                                                                        Cancel
                                                                    </button>
                                                                </form>
                                                            @endif

                                                            <a href="{{ route('forum.index', ['eventId' => $event->id]) }}"
                                                                class="inline-flex items-center justify-center w-16 px-2 py-1.5 text-xs font-medium rounded border border-purple-200 bg-purple-50 text-purple-700 hover:bg-purple-100 dark:bg-purple-900/20 dark:text-purple-300 dark:border-purple-700 dark:hover:bg-purple-900/30 transition-colors">
                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                    class="h-3 w-3 mr-1" fill="none"
                                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2"
                                                                        d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                                                                </svg>
                                                                Forum
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
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
