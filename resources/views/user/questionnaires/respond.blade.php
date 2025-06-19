<x-app-layout>
    <div
        class="flex flex-col min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800">
        <main class="flex-grow py-6 sm:py-8 md:py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 shadow-lg sm:rounded-xl overflow-hidden">
                    <div class="relative bg-unimasblue dark:bg-unimasblue p-6">
                        <div class="absolute inset-0 opacity-10 bg-pattern-grid"></div>
                        <h1 class="text-2xl sm:text-3xl font-bold text-center text-white">
                            {{ $questionnaire->title }}
                        </h1>
                    </div>

                    <div class="p-4 sm:p-6 md:p-8">
                        @if ($questionnaire->description)
                            <div class="mb-8 text-gray-600 dark:text-gray-400">
                                {{ $questionnaire->description }}
                            </div>
                        @endif

                        <form action="{{ route('user.questionnaires.store-response', $questionnaire) }}" method="POST">
                            @csrf

                            <div class="space-y-8">
                                @foreach ($questionnaire->questions as $question)
                                    <div
                                        class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-6">
                                        <label class="block text-lg font-medium text-gray-900 dark:text-white mb-4">
                                            {{ $question->question_text }}
                                            @if ($question->is_required)
                                                <span class="text-red-500">*</span>
                                            @endif
                                        </label>

                                        @switch($question->question_type)
                                            @case('text')
                                                <textarea name="responses[{{ $question->id }}]" rows="3"
                                                    class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                                    {{ $question->is_required ? 'required' : '' }}></textarea>
                                            @break

                                            @case('multiple_choice')
                                                <div class="space-y-3">
                                                    @foreach ($question->options as $option)
                                                        <div class="flex items-center">
                                                            <input type="radio" name="responses[{{ $question->id }}]"
                                                                value="{{ $option->option_text }}"
                                                                class="h-4 w-4 border-gray-300 text-blue-600 focus:ring-blue-500"
                                                                {{ $question->is_required ? 'required' : '' }}>
                                                            <label class="ml-3 text-gray-700 dark:text-gray-300">
                                                                {{ $option->option_text }}
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @break

                                            @case('checkbox')
                                                <div class="space-y-3">
                                                    @foreach ($question->options as $option)
                                                        <div class="flex items-center">
                                                            <input type="checkbox" name="responses[{{ $question->id }}][]"
                                                                value="{{ $option->option_text }}"
                                                                class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                                            <label class="ml-3 text-gray-700 dark:text-gray-300">
                                                                {{ $option->option_text }}
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @break

                                            @case('rating')
                                                <div class="flex space-x-4">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        <label class="flex flex-col items-center">
                                                            <input type="radio" name="responses[{{ $question->id }}]"
                                                                value="{{ $i }}"
                                                                class="h-4 w-4 border-gray-300 text-blue-600 focus:ring-blue-500"
                                                                {{ $question->is_required ? 'required' : '' }}>
                                                            <span
                                                                class="mt-1 text-gray-700 dark:text-gray-300">{{ $i }}</span>
                                                        </label>
                                                    @endfor
                                                </div>
                                            @break
                                        @endswitch
                                    </div>
                                @endforeach
                            </div>

                            <div class="mt-8 flex justify-end">
                                <button type="submit"
                                    class="px-6 py-3 bg-unimasblue hover:bg-blue-700 text-white font-medium rounded-lg transition duration-300 shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                                    Submit Response
                                </button>
                            </div>
                        </form>
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
