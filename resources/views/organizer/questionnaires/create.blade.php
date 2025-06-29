<x-app-layout>
    <div
        class="flex flex-col min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800">
        <main class="flex-grow py-6 sm:py-8 md:py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 shadow-lg sm:rounded-xl overflow-hidden">
                    <div class="relative bg-unimasblue dark:bg-unimasblue p-6">
                        <div class="absolute inset-0 opacity-10 bg-pattern-grid"></div>
                        <h2 class="text-2xl sm:text-3xl font-bold text-center text-white">
                            Create New Questionnaire
                        </h2>
                    </div>
                    <div class="p-4 sm:p-6 md:p-8">
                        <form action="{{ route('organizer.questionnaires.store') }}" method="POST"
                            id="questionnaireForm">
                            @csrf
                            <div class="mb-4">
                                <label class="block text-gray-700 dark:text-gray-200 text-sm font-bold mb-2"
                                    for="title">
                                    Title
                                </label>
                                <input type="text" name="title" id="title" required
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-200 dark:bg-gray-900 leading-tight focus:outline-none focus:shadow-outline">
                            </div>

                            <div class="mb-4">
                                <label class="block text-gray-700 dark:text-gray-200 text-sm font-bold mb-2"
                                    for="description">
                                    Description
                                </label>
                                <textarea name="description" id="description"
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-200 dark:bg-gray-900 leading-tight focus:outline-none focus:shadow-outline"
                                    rows="3"></textarea>
                            </div>

                            <div class="mb-4">
                                <label class="block text-gray-700 dark:text-gray-200 text-sm font-bold mb-2"
                                    for="event_id">
                                    Event
                                </label>
                                <select name="event_id" id="event_id" required
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-200 dark:bg-gray-900 leading-tight focus:outline-none focus:shadow-outline bg-white dark:bg-gray-900">
                                    <option value="" disabled selected>Select an event</option>
                                    @forelse($events as $event)
                                        <option value="{{ $event->id }}">{{ $event->name }}</option>
                                    @empty
                                        <option value="" disabled>No available events found</option>
                                    @endforelse
                                </select>
                                @error('event_id')
                                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                                @enderror
                                @if ($events->isEmpty())
                                    <p class="text-gray-500 text-xs italic mt-1">
                                        You need to create an approved event before creating a questionnaire.
                                    </p>
                                @endif
                            </div>

                            <div id="questions-container">
                                <!-- Questions will be added here dynamically -->
                            </div>

                            <input type="hidden" id="hasQuestions" name="has_questions" value="0">

                            @if ($errors->any())
                                <div
                                    class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <button type="button" id="addQuestion"
                                class="px-4 py-2 bg-unimasblue hover:bg-blue-700 text-white font-medium rounded-lg transition duration-300 shadow-md hover:shadow-lg transform hover:-translate-y-0.5 mb-4">
                                Add Question
                            </button>

                            <div class="mt-6 flex justify-end">
                                <button type="submit"
                                    class="px-6 py-3 bg-unimasblue hover:bg-blue-700 text-white font-medium rounded-lg transition duration-300 shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                                    Create Questionnaire
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>
        <footer class="bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 mt-8">
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

    <script>
        let questionCount = 0;

        function addQuestion() {
            questionCount++;
            const questionHTML = `
                <div class="question-block bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl p-6 mb-6 shadow hover:shadow-md transition-shadow duration-300" data-question="${questionCount}">
                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-200 text-sm font-bold mb-2">Question Text</label>
                        <input type="text"
                            name="questions[${questionCount}][question_text]"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-200 dark:bg-gray-800 leading-tight focus:outline-none focus:shadow-outline"
                            required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-200 text-sm font-bold mb-2">Question Type</label>
                        <select name="questions[${questionCount}][question_type]"
                            onchange="toggleOptions(${questionCount})"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-200 dark:bg-gray-800 leading-tight focus:outline-none focus:shadow-outline">
                            <option value="text">Text</option>
                            <option value="multiple_choice">Multiple Choice</option>
                            <option value="checkbox">Checkbox</option>
                            <option value="rating">Rating</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-200 text-sm font-bold mb-2">
                            <input type="checkbox"
                                name="questions[${questionCount}][is_required]"
                                value="1">
                            Required
                        </label>
                    </div>

                    <div id="options-container-${questionCount}" style="display: none;">
                        <div class="mb-4">
                            <label class="block text-gray-700 dark:text-gray-200 text-sm font-bold mb-2">Options</label>
                            <div id="options-list-${questionCount}"></div>
                            <button type="button"
                                onclick="addOption(${questionCount})"
                                class="mt-2 bg-unimasblue hover:bg-blue-700 text-white font-bold py-1 px-3 rounded text-sm transition duration-300">
                                Add Option
                            </button>
                        </div>
                    </div>

                    <button type="button"
                        onclick="removeQuestion(${questionCount})"
                        class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded text-sm transition duration-300">
                        Remove Question
                    </button>
                </div>
            `;
            document.getElementById('questions-container').insertAdjacentHTML('beforeend', questionHTML);
        }

        function toggleOptions(questionNum) {
            const questionType = document.querySelector(`select[name="questions[${questionNum}][question_type]"]`).value;
            const optionsContainer = document.getElementById(`options-container-${questionNum}`);

            if (questionType === 'multiple_choice' || questionType === 'checkbox') {
                optionsContainer.style.display = 'block';
                if (!document.querySelector(`#options-list-${questionNum} .option-item`)) {
                    addOption(questionNum); // Add first option by default
                }
            } else {
                optionsContainer.style.display = 'none';
            }
        }

        function addOption(questionNum) {
            const optionCount = document.querySelectorAll(`#options-list-${questionNum} .option-item`).length;
            const optionHTML = `
                <div class="option-item flex items-center mb-2">
                    <input type="text"
                        name="questions[${questionNum}][options][]"
                        class="shadow appearance-none border rounded flex-1 py-2 px-3 text-gray-700 dark:text-gray-200 dark:bg-gray-800 leading-tight focus:outline-none focus:shadow-outline mr-2"
                        placeholder="Option ${optionCount + 1}"
                        required>
                    <button type="button"
                        onclick="this.parentElement.remove()"
                        class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded text-sm transition duration-300">
                        Remove
                    </button>
                </div>
            `;
            document.getElementById(`options-list-${questionNum}`).insertAdjacentHTML('beforeend', optionHTML);
        }

        function removeQuestion(questionNum) {
            document.querySelector(`[data-question="${questionNum}"]`).remove();
        }

        document.getElementById('addQuestion').addEventListener('click', addQuestion);

        // Form validation before submit
        document.getElementById('questionnaireForm').addEventListener('submit', function(e) {
            const questions = document.querySelectorAll('.question-block');
            let isValid = true;

            questions.forEach(question => {
                const type = question.querySelector('select[name*="[question_type]"]').value;
                if ((type === 'multiple_choice' || type === 'checkbox')) {
                    const options = question.querySelectorAll('input[name*="[options][]"]');
                    if (options.length < 2) {
                        alert('Multiple choice and checkbox questions must have at least 2 options');
                        isValid = false;
                    }
                    options.forEach(option => {
                        if (!option.value.trim()) {
                            alert('All options must have a value');
                            isValid = false;
                        }
                    });
                }
            });

            if (!isValid) {
                e.preventDefault();
            }
        });
    </script>
    <style>
        .option-item {
            transition: all 0.3s ease;
        }

        .option-item:hover {
            background-color: #f8f9fa;
        }

        .question-block {
            position: relative;
            transition: all 0.3s ease;
        }

        .question-block:hover {
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
    </style>
</x-app-layout>
