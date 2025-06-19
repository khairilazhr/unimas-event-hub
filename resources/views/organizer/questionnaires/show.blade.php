<x-app-layout>
    <div
        class="flex flex-col min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800">
        <main class="flex-grow py-6 sm:py-8 md:py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 shadow-lg sm:rounded-xl overflow-hidden">
                    <div class="relative bg-unimasblue dark:bg-unimasblue p-6">
                        <div class="absolute inset-0 opacity-10 bg-pattern-grid pointer-events-none"></div>
                        <div class="flex justify-between items-center">
                            <h1 class="text-2xl sm:text-3xl font-bold text-white">
                                {{ $questionnaire->title }}
                            </h1>
                            <a href="{{ route('organizer.questionnaires.index') }}"
                                class="inline-flex items-center px-4 py-2 bg-white/10 hover:bg-white/20 text-white text-sm font-medium rounded-lg transition duration-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 17l-5-5m0 0l5-5m-5 5h12" />
                                </svg>
                                Back to Questionnaires
                            </a>
                        </div>
                    </div>

                    <div class="p-4 sm:p-6 md:p-8">
                        <div class="mb-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div
                                class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl shadow-sm p-6">
                                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Description</h2>
                                <p class="text-gray-700 dark:text-gray-300 mb-2">{{ $questionnaire->description }}</p>
                                <div class="text-sm text-gray-500 dark:text-gray-400 mb-1">
                                    <span class="font-medium">Event:</span> {{ $questionnaire->event->name }}
                                </div>
                                <div class="text-sm text-gray-500 dark:text-gray-400 mb-1">
                                    <span class="font-medium">Status:</span>
                                    @if ($questionnaire->published_at)
                                        <span
                                            class="px-2 py-1 rounded bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100">Published</span>
                                    @else
                                        <span
                                            class="px-2 py-1 rounded bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100">Draft</span>
                                    @endif
                                </div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">
                                    <span class="font-medium">Last Updated:</span>
                                    {{ $questionnaire->updated_at->diffForHumans() }}
                                </div>
                            </div>
                        </div>

                        <div class="mb-4 flex items-center justify-between">
                            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Questions</h2>
                            <span class="text-sm text-gray-500 dark:text-gray-400">Total:
                                {{ $questionnaire->questions->count() }}</span>
                        </div>
                        <div class="space-y-6">
                            @foreach ($questionnaire->questions as $question)
                                <div
                                    class="bg-gray-50 dark:bg-gray-700/50 border border-gray-200 dark:border-gray-600 rounded-lg p-4">
                                    <div class="flex items-center justify-between mb-2">
                                        <div class="font-medium text-gray-900 dark:text-white">
                                            {{ $loop->iteration }}. {{ $question->question_text }}
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <span
                                                class="px-2 py-0.5 rounded text-xs font-semibold bg-blue-100 text-blue-800 dark:bg-blue-900/20 dark:text-blue-400 capitalize">
                                                {{ str_replace('_', ' ', $question->question_type) }}
                                            </span>
                                            @if ($question->is_required)
                                                <span
                                                    class="px-2 py-0.5 rounded text-xs font-semibold bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-400">Required</span>
                                            @endif
                                        </div>
                                    </div>
                                    @if (in_array($question->question_type, ['multiple_choice', 'checkbox']) && $question->options->count())
                                        <ul class="list-disc list-inside ml-4 mt-2">
                                            @foreach ($question->options as $option)
                                                <li class="text-gray-800 dark:text-gray-200">{{ $option->option_text }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                            @endforeach
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
