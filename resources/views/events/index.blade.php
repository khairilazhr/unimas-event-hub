<x-app-layout>
    <div class="py-12 bg-gray-100 dark:bg-gray-900">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-md sm:rounded-lg px-6 py-10">
                <h1 class="text-3xl font-semibold text-center text-gray-800 dark:text-white mb-12">
                    ✨ Available Events
                </h1>

                @if($events->isEmpty())
                    <p class="text-center text-gray-500 dark:text-gray-400 text-lg italic">No events available at the moment.</p>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        @foreach($events as $event)
                            <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl overflow-hidden shadow hover:shadow-lg transition duration-300">
                                <div class="flex flex-col h-full">
                                    @if($event->poster)
                                        <img src="data:image/jpeg;base64,{{ base64_encode($event->poster) }}"
                                            alt="Event Poster"
                                            class="w-full h-56 object-cover rounded-t-xl">
                                    @else
                                        <div class="w-full h-56 bg-gray-200 dark:bg-gray-700 flex items-center justify-center text-gray-500 dark:text-gray-400 italic text-sm">
                                            No Poster Available
                                        </div>
                                    @endif

                                    <div class="flex-grow p-5 flex flex-col justify-between">
                                        <div>
                                            <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-2">
                                                {{ $event->title }}
                                            </h3>
                                            <p class="text-gray-600 dark:text-gray-300 text-sm mb-4 line-clamp-3">
                                                {{ $event->description }}
                                            </p>

                                            <ul class="text-sm text-gray-500 dark:text-gray-400 space-y-1">
                                                <li><span class="font-medium text-gray-700 dark:text-gray-300">Organizer:</span> {{ $event->organizer_name }}</li>
                                                <li><span class="font-medium text-gray-700 dark:text-gray-300">Date:</span> {{ \Carbon\Carbon::parse($event->event_date)->format('d M Y') }}</li>
                                                <li><span class="font-medium text-gray-700 dark:text-gray-300">Location:</span> {{ $event->location }}</li>
                                            </ul>
                                        </div>

                                        <div class="mt-6">
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
                @endif
            </div>

            <!-- Resources Footer -->
            <div class="mt-12 bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
                <div class="p-6 border-t border-gray-200 dark:border-gray-700">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-3">Resources</h3>
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
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-3">Need Help?</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">Have questions or need assistance? We’re here for you.</p>
                            <button class="inline-block px-4 py-2 text-sm font-medium text-gray-700 dark:text-white bg-gray-100 dark:bg-gray-700 rounded hover:bg-gray-200 dark:hover:bg-gray-600 transition">
                                Contact Support
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
