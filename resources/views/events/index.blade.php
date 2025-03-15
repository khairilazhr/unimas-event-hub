<x-app-layout>
    <div class="flex flex-col min-h-screen bg-gray-100 dark:bg-gray-900">
        {{-- Main Content --}}
        <main class="flex-grow py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 shadow-md sm:rounded-2xl p-8 sm:p-10">
                    <h1 class="text-3xl font-bold text-center text-gray-800 dark:text-white mb-10">
                        ✨ Available Events
                    </h1>

                    @if($events->isEmpty())
                        <p class="text-center text-gray-500 dark:text-gray-400 text-lg italic">
                            No events available at the moment.
                        </p>
                    @else
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($events as $event)
                                <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl overflow-hidden shadow hover:shadow-lg transition duration-300">
                                    <div class="flex flex-col h-full">
                                        @if($event->poster)
                                            <img src="data:image/jpeg;base64,{{ base64_encode($event->poster) }}"
                                                 alt="Event Poster"
                                                 class="w-full h-40 object-cover">
                                        @else
                                            <div class="w-full h-40 bg-gray-200 dark:bg-gray-700 flex items-center justify-center text-gray-500 dark:text-gray-400 italic text-sm">
                                                No Poster Available
                                            </div>
                                        @endif

                                        <div class="flex-grow p-5 flex flex-col justify-between">
                                            <div>
                                                <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-2">
                                                    {{ $event->title }}
                                                </h3>
                                                <p class="text-sm text-gray-600 dark:text-gray-300 mb-3 line-clamp-3">
                                                    {{ $event->description }}
                                                </p>
                                                <ul class="text-xs text-gray-500 dark:text-gray-400 space-y-1">
                                                    <li>
                                                        <span class="font-medium text-gray-700 dark:text-gray-300">Organizer:</span>
                                                        {{ $event->organizer_name }}
                                                    </li>
                                                    <li>
                                                        <span class="font-medium text-gray-700 dark:text-gray-300">Date:</span>
                                                        {{ \Carbon\Carbon::parse($event->event_date)->format('d M Y') }}
                                                    </li>
                                                    <li>
                                                        <span class="font-medium text-gray-700 dark:text-gray-300">Location:</span>
                                                        {{ $event->location }}
                                                    </li>
                                                </ul>
                                            </div>

                                            <div class="mt-4">
                                                <a href="{{ route('user.events.register', $event->id) }}"
                                                   class="inline-block w-full text-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg transition duration-200">
                                                    Register Now
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        {{-- Pagination Controls --}}
                        <div class="mt-10 flex justify-center">
                            {{ $events->links() }}
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
                        <button class="inline-block px-4 py-2 text-sm font-medium text-white bg-gray-700 hover:bg-gray-600 rounded-lg transition">
                            Contact Support
                        </button>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</x-app-layout>
