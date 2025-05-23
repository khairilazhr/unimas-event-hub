<x-app-layout>
    <div class="min-h-screen flex flex-col">
        <main class="flex-grow py-6 sm:py-8 md:py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 shadow-lg sm:rounded-xl overflow-hidden">
                    <!-- Header Section -->
                    <div class="relative bg-unimasblue dark:bg-unimasblue p-6">
                        <div class="absolute inset-0 opacity-10 bg-pattern-grid"></div>
                        <div class="flex items-center justify-between">
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
                                    <span class="px-3 py-1 rounded-full text-sm font-medium
                                        {{ $event->status === 'approved' ? 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100' :
                                        ($event->status === 'pending' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100' :
                                        'bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100') }}">
                                        {{ ucfirst($event->status) }}
                                    </span>
                                </div>
                                @if($event->status === 'pending')
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
                                    <h2 class="text-xl font-semibold mb-4 text-gray-900 dark:text-white">Event Information</h2>
                                    <div class="grid grid-cols-2 gap-4">
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
                                            <dt class="text-sm text-gray-500 dark:text-gray-400">Organizer</dt>
                                            <dd class="mt-1 text-gray-900 dark:text-white">
                                                {{ $event->organizer->name }}
                                                <span class="text-gray-500 dark:text-gray-400 text-sm">({{ $event->organizer->email }})</span>
                                            </dd>
                                        </div>
                                    </div>
                                </div>

                                <!-- Description Card -->
                                <div class="bg-white dark:bg-gray-700 p-6 rounded-xl shadow-sm">
                                    <h2 class="text-xl font-semibold mb-4 text-gray-900 dark:text-white">Description</h2>
                                    <p class="text-gray-700 dark:text-gray-300 whitespace-pre-wrap">{{ $event->description }}</p>
                                </div>

                                <!-- Poster Card -->
                                @if($event->poster)
                                <div class="bg-white dark:bg-gray-700 p-6 rounded-xl shadow-sm">
                                    <h2 class="text-xl font-semibold mb-4 text-gray-900 dark:text-white">Event Poster</h2>
                                    <div class="aspect-[3/2] rounded-lg overflow-hidden">
                                        <img src="{{ $event->poster_url }}"
                                             alt="Event poster"
                                             class="w-full h-full object-cover">
                                    </div>
                                </div>
                                @endif
                            </div>

                            <!-- Statistics Column -->
                            <div class="space-y-6">
                                <!-- Statistics Card -->
                                <div class="bg-white dark:bg-gray-700 p-6 rounded-xl shadow-sm">
                                    <h2 class="text-xl font-semibold mb-4 text-gray-900 dark:text-white">Event Statistics</h2>
                                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                        <div class="text-center p-4 bg-gray-50 dark:bg-gray-600 rounded-lg">
                                            <dt class="text-sm text-gray-500 dark:text-gray-400">Total Tickets</dt>
                                            <dd class="mt-1 text-2xl font-bold text-gray-900 dark:text-white">
                                                {{ $event->tickets->sum('quantity') }}
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
                                    </div>
                                </div>

                                <!-- Recent Registrations Card -->
                                <div class="bg-white dark:bg-gray-700 p-6 rounded-xl shadow-sm">
                                    <h2 class="text-xl font-semibold mb-4 text-gray-900 dark:text-white">Recent Registrations</h2>
                                    <div class="space-y-3">
                                        @forelse($event->registrations->take(5) as $registration)
                                        <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-600 rounded-lg">
                                            <div>
                                                <p class="font-medium text-gray-900 dark:text-white">{{ $registration->user->name }}</p>
                                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                                    {{ $registration->created_at->diffForHumans() }}
                                                </p>
                                            </div>
                                            <span class="px-2 py-1 text-sm rounded-full
                                                {{ $registration->status === 'confirmed' ? 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100' :
                                                'bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100' }}">
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
        {{-- Footer --}}
        <footer class="bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div>
                        <div class="font-bold text-xl mb-4 text-gray-800 dark:text-white">EventHub</div>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">
                            Bringing people together through memorable events and experiences.
                        </p>
                        <div class="flex space-x-4">
                            <a href="#" class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300">
                                <span class="sr-only">Facebook</span>
                                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path fill-rule="evenodd"
                                        d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"
                                        clip-rule="evenodd" />
                                </svg>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300">
                                <span class="sr-only">Instagram</span>
                                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path fill-rule="evenodd"
                                        d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z"
                                        clip-rule="evenodd" />
                                </svg>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300">
                                <span class="sr-only">Twitter</span>
                                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path
                                        d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" />
                                </svg>
                            </a>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-base font-semibold text-gray-800 dark:text-white mb-4">Resources</h3>
                        <div class="grid grid-cols-2 gap-2">
                            <a href="#"
                                class="text-sm text-gray-600 dark:text-gray-400 hover:text-unimasblue dark:hover:text-unimasblue transition">FAQ</a>
                            <a href="#"
                                class="text-sm text-gray-600 dark:text-gray-400 hover:text-unimasblue dark:hover:text-unimasblue transition">Help
                                Center</a>
                            <a href="#"
                                class="text-sm text-gray-600 dark:text-gray-400 hover:text-unimasblue dark:hover:text-unimasblue transition">User
                                Guide</a>
                            <a href="#"
                                class="text-sm text-gray-600 dark:text-gray-400 hover:text-unimasblue dark:hover:text-unimasblue transition">Terms</a>
                            <a href="#"
                                class="text-sm text-gray-600 dark:text-gray-400 hover:text-unimasblue dark:hover:text-unimasblue transition">Privacy</a>
                            <a href="#"
                                class="text-sm text-gray-600 dark:text-gray-400 hover:text-unimasblue dark:hover:text-unimasblue transition">Contact</a>
                        </div>
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

                <div
                    class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700 text-center text-sm text-gray-500 dark:text-gray-400">
                    <p>© 2025 EventHub. All rights reserved.</p>
                </div>
            </div>
        </footer>
    </div>
</x-app-layout>
