<x-app-layout>
    <div
        class="flex flex-col min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800">
        {{-- Main Content --}}
        <main class="flex-grow py-6 sm:py-8 md:py-12">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 shadow-lg sm:rounded-xl overflow-hidden">
                    <div class="relative bg-unimasblue dark:bg-unimasblue p-6">
                        <div class="absolute inset-0 opacity-10 bg-pattern-grid"></div>
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                            <div>
                                <h1 class="text-xl sm:text-2xl font-bold text-white line-clamp-2">
                                    {{ $topic->title }}
                                </h1>
                                <p class="mt-1 text-white/80 text-sm">
                                    Event: {{ $event->name }}
                                </p>
                            </div>
                            <a href="{{ route('forum.index', $event->id) }}"
                                class="inline-flex items-center px-5 py-2.5 bg-unimasblue hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition duration-300 shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                                Back to Forum
                            </a>
                        </div>
                    </div>

                    <div class="p-4 sm:p-6 md:p-8">
                        @if (session('success'))
                            <div
                                class="mb-6 p-4 bg-green-100 border border-green-200 text-green-700 rounded-lg dark:bg-green-800 dark:border-green-700 dark:text-green-100">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if (session('error'))
                            <div
                                class="mb-6 p-4 bg-red-100 border border-red-200 text-red-700 rounded-lg dark:bg-red-800 dark:border-red-700 dark:text-red-100">
                                {{ session('error') }}
                            </div>
                        @endif

                        <!-- Original Question -->
                        <div class="mb-8 border border-gray-200 dark:border-gray-700 rounded-xl overflow-hidden">
                            <div
                                class="flex items-center justify-between bg-gray-50 dark:bg-gray-750 px-4 py-3 border-b border-gray-200 dark:border-gray-700">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <div
                                            class="w-10 h-10 rounded-full bg-unimasblue flex items-center justify-center text-white font-medium text-lg">
                                            {{ $topic->user_id === $event->organizer_id ? 'O' : substr($topic->user->name, 0, 1) }}
                                        </div>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900 dark:text-white">
                                            @if ($topic->user_id === $event->organizer_id)
                                                <span
                                                    class="bg-purple-100 text-purple-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-purple-900 dark:text-purple-100">
                                                    Organizer
                                                </span>
                                            @else
                                                {{ $topic->user->name }}
                                            @endif
                                        </p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ $topic->created_at->diffForHumans() }}
                                        </p>
                                    </div>
                                </div>
                                <div>
                                    @if ($topic->is_resolved)
                                        <span
                                            class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7" />
                                            </svg>
                                            Solved
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            Unsolved
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="p-4 sm:p-6 bg-white dark:bg-gray-800">
                                <div class="prose dark:prose-invert max-w-none">
                                    {{ $topic->content }}
                                </div>
                            </div>
                        </div>

                        <!-- Replies -->
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                                {{ $topic->replies->count() }} {{ Str::plural('Answer', $topic->replies->count()) }}
                            </h3>

                            @forelse($topic->replies as $reply)
                                <div
                                    class="mb-4 border border-gray-200 dark:border-gray-700 rounded-xl overflow-hidden {{ $reply->is_answer ? 'ring-2 ring-green-500 dark:ring-green-400' : '' }}">
                                    <div
                                        class="flex items-center justify-between bg-gray-50 dark:bg-gray-750 px-4 py-3 border-b border-gray-200 dark:border-gray-700">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0">
                                                <div
                                                    class="w-10 h-10 rounded-full bg-gray-300 dark:bg-gray-600 flex items-center justify-center text-gray-700 dark:text-gray-200 font-medium text-lg">
                                                    {{ $reply->user_id === $event->organizer_id ? 'O' : substr($reply->user->name, 0, 1) }}
                                                </div>
                                            </div>
                                            <div class="ml-3">
                                                <p class="text-sm font-medium text-gray-900 dark:text-white">
                                                    @if ($reply->user_id === $event->organizer_id)
                                                        <span
                                                            class="bg-purple-100 text-purple-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-purple-900 dark:text-purple-100">
                                                            Organizer
                                                        </span>
                                                    @else
                                                        {{ $reply->user->name }}
                                                    @endif
                                                </p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                                    {{ $reply->created_at->diffForHumans() }}
                                                </p>
                                            </div>
                                        </div>
                                        @if ($reply->is_answer)
                                            <div
                                                class="flex items-center text-green-600 dark:text-green-400 text-sm font-medium">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                Solution
                                            </div>
                                        @elseif((Auth::id() == $topic->user_id || Auth::id() == $event->organizer_id) && !$topic->is_resolved)
                                            <form
                                                action="{{ route('forum.mark-as-answer', ['eventId' => $event->id, 'topicId' => $topic->id, 'replyId' => $reply->id]) }}"
                                                method="POST">
                                                @csrf
                                                <button type="submit"
                                                    class="text-sm text-unimasblue hover:text-indigo-700 dark:hover:text-indigo-400 font-medium inline-flex items-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M5 13l4 4L19 7" />
                                                    </svg>
                                                    Mark as Solution
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                    <div class="p-4 sm:p-6 bg-white dark:bg-gray-800">
                                        <div class="prose dark:prose-invert max-w-none">
                                            {{ $reply->content }}
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div
                                    class="flex flex-col items-center justify-center py-6 text-center bg-gray-50 dark:bg-gray-750 rounded-xl border border-gray-200 dark:border-gray-700">
                                    <div class="text-gray-400 dark:text-gray-500 mb-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                        </svg>
                                    </div>
                                    <p class="text-gray-600 dark:text-gray-300 font-medium">
                                        No answers yet
                                    </p>
                                    <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">
                                        Be the first to answer this question!
                                    </p>
                                </div>
                            @endforelse
                        </div>

                        <!-- Post Reply Form -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                                Your Answer
                            </h3>
                            <form
                                action="{{ route('forum.store-reply', ['eventId' => $event->id, 'topicId' => $topic->id]) }}"
                                method="POST">
                                @csrf

                                <div class="mb-4">
                                    <textarea id="content" name="content" rows="5"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-unimasblue focus:border-unimasblue block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-unimasblue dark:focus:border-unimasblue"
                                        placeholder="Type your answer here..." required>{{ old('content') }}</textarea>
                                    @error('content')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>

                                @if (auth()->user()->id === $event->organizer_id)
                                    <div class="mb-4 text-sm text-purple-600 dark:text-purple-400">
                                        You're replying as the Event Organizer
                                    </div>
                                @endif

                                <div class="flex justify-end">
                                    <button type="submit"
                                        class="px-4 py-2 text-sm font-medium text-white bg-unimasblue rounded-lg hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-300 dark:bg-unimasblue dark:hover:bg-indigo-700 dark:focus:ring-indigo-800">
                                        Post Answer
                                    </button>
                                </div>
                            </form>
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
