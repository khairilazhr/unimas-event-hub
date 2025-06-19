<x-app-layout>
    <div
        class="flex flex-col min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800">
        <main class="flex-grow py-6 sm:py-8 md:py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 shadow-lg sm:rounded-xl overflow-hidden">
                    <div class="relative bg-unimasblue dark:bg-unimasblue p-6">
                        <div class="absolute inset-0 opacity-10 bg-pattern-grid"></div>
                        <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                            <h1 class="text-2xl sm:text-3xl font-bold text-white">
                                {{ $questionnaire->title }}
                            </h1>
                            <div class="flex gap-4 items-center">
                                <div class="bg-white bg-opacity-20 rounded-lg px-4 py-2">
                                    <span class="text-white text-sm font-medium">Total Respondents:</span>
                                    <span class="text-white text-lg font-bold ml-2">
                                        {{ $responses->pluck('user_id')->unique()->count() }}
                                    </span>
                                </div>
                                <div class="bg-white bg-opacity-20 rounded-lg px-4 py-2">
                                    <span class="text-white text-sm font-medium">Response Rate:</span>
                                    <span class="text-white text-lg font-bold ml-2">
                                        @php
                                            $totalRegistrations = $questionnaire->event->registrations()->count();
                                            $responseRate =
                                                $totalRegistrations > 0
                                                    ? round(
                                                        ($responses->pluck('user_id')->unique()->count() /
                                                            $totalRegistrations) *
                                                            100,
                                                        1,
                                                    )
                                                    : 0;
                                        @endphp
                                        {{ $responseRate }}%
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="p-4 sm:p-6 md:p-8">
                        @if ($questionnaire->description)
                            <div class="mb-8 text-gray-600 dark:text-gray-400">
                                {{ $questionnaire->description }}
                            </div>
                        @endif

                        @foreach ($questionnaire->questions as $question)
                            <div
                                class="mb-8 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-6">
                                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">
                                    {{ $question->question_text }}
                                    @if ($question->is_required)
                                        <span class="text-red-500">*</span>
                                    @endif
                                </h3>

                                @switch($question->question_type)
                                    @case('text')
                                        <div class="space-y-4">
                                            @foreach ($responses->where('question_id', $question->id) as $response)
                                                <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                                    <p class="text-gray-700 dark:text-gray-300">{{ $response->response_value }}
                                                    </p>
                                                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">
                                                        Responded by: {{ $response->user->name }} on
                                                        {{ $response->created_at->format('M d, Y H:i') }}
                                                    </p>
                                                </div>
                                            @endforeach
                                        </div>
                                    @break

                                    @case('multiple_choice')
                                    @case('checkbox')
                                        @php
                                            $optionCounts = [];
                                            foreach ($question->options as $option) {
                                                $optionCounts[$option->option_text] = 0;
                                            }
                                            foreach ($responses->where('question_id', $question->id) as $response) {
                                                $values =
                                                    $question->question_type === 'checkbox'
                                                        ? json_decode($response->response_value)
                                                        : [$response->response_value];
                                                foreach ($values as $value) {
                                                    if (isset($optionCounts[$value])) {
                                                        $optionCounts[$value]++;
                                                    }
                                                }
                                            }
                                        @endphp
                                        <div class="space-y-4">
                                            @foreach ($optionCounts as $option => $count)
                                                <div class="relative">
                                                    <div class="flex justify-between mb-1">
                                                        <span
                                                            class="text-gray-700 dark:text-gray-300">{{ $option }}</span>
                                                        <span class="text-gray-600 dark:text-gray-400">{{ $count }}
                                                            responses</span>
                                                    </div>
                                                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2.5">
                                                        @php
                                                            $percentage =
                                                                $responses
                                                                    ->where('question_id', $question->id)
                                                                    ->count() > 0
                                                                    ? ($count /
                                                                            $responses
                                                                                ->where('question_id', $question->id)
                                                                                ->count()) *
                                                                        100
                                                                    : 0;
                                                        @endphp
                                                        <div class="bg-blue-600 h-2.5 rounded-full"
                                                            style="width: {{ $percentage }}%"></div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @break

                                    @case('rating')
                                        @php
                                            $ratingCounts = array_fill(1, 5, 0);
                                            $responses
                                                ->where('question_id', $question->id)
                                                ->each(function ($response) use (&$ratingCounts) {
                                                    $ratingCounts[(int) $response->response_value]++;
                                                });
                                            $averageRating = $responses
                                                ->where('question_id', $question->id)
                                                ->average('response_value');
                                        @endphp
                                        <div class="mb-4">
                                            <div class="flex items-center space-x-2">
                                                <span class="text-lg font-medium text-gray-700 dark:text-gray-300">
                                                    Average Rating:
                                                </span>
                                                <span class="text-2xl font-bold text-blue-600">
                                                    {{ number_format($averageRating, 1) }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="space-y-3">
                                            @foreach ($ratingCounts as $rating => $count)
                                                <div class="relative">
                                                    <div class="flex justify-between mb-1">
                                                        <div class="flex items-center">
                                                            <span class="text-gray-700 dark:text-gray-300">{{ $rating }}
                                                                star</span>
                                                        </div>
                                                        <span class="text-gray-600 dark:text-gray-400">{{ $count }}
                                                            responses</span>
                                                    </div>
                                                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2.5">
                                                        @php
                                                            $percentage =
                                                                $responses
                                                                    ->where('question_id', $question->id)
                                                                    ->count() > 0
                                                                    ? ($count /
                                                                            $responses
                                                                                ->where('question_id', $question->id)
                                                                                ->count()) *
                                                                        100
                                                                    : 0;
                                                        @endphp
                                                        <div class="bg-blue-600 h-2.5 rounded-full"
                                                            style="width: {{ $percentage }}%"></div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @break
                                @endswitch
                            </div>
                        @endforeach

                        <div class="mt-8 flex justify-end space-x-4">
                            <a href="{{ route('organizer.questionnaires.index') }}"
                                class="px-6 py-3 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition duration-300 shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                                Back to Questionnaires
                            </a>
                            <button onclick="window.print()"
                                class="px-6 py-3 bg-unimasblue hover:bg-blue-700 text-white font-medium rounded-lg transition duration-300 shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                                <span class="flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                    </svg>
                                    Print Responses
                                </span>
                            </button>
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
