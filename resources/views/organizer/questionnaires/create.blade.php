<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="text-2xl font-bold mb-4">Create New Questionnaire</h2>

                    <form action="{{ route('organizer.questionnaires.store') }}" method="POST" id="questionnaireForm">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="title">
                                Title
                            </label>
                            <input type="text" name="title" id="title" required
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="description">
                                Description
                            </label>
                            <textarea name="description" id="description"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                rows="3"></textarea>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="event_id">
                                Event
                            </label>
                            <select name="event_id" id="event_id" required
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline bg-white">
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
                            @if($events->isEmpty())
                                <p class="text-gray-500 text-xs italic mt-1">
                                    You need to create an approved event before creating a questionnaire.
                                </p>
                            @endif
                        </div>

                        <div id="questions-container">
                            <!-- Questions will be added here dynamically -->
                        </div>

                        <!-- Add this hidden input if no questions are added -->
                        <input type="hidden" id="hasQuestions" name="has_questions" value="0">

                        <!-- Add error messages display -->
                        @if ($errors->any())
                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <button type="button" id="addQuestion"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4">
                            Add Question
                        </button>

                        <!-- Modify the submit button to include form validation -->
                        <div class="mt-6">
                            <button type="submit"
                                onclick="return validateForm()"
                                class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                Create Questionnaire
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        let questionCount = 0;

        function addQuestion() {
            questionCount++;
            const questionHTML = `
                <div class="question-block border rounded p-4 mb-4" data-question="${questionCount}">
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Question Text</label>
                        <input type="text"
                            name="questions[${questionCount}][question_text]"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Question Type</label>
                        <select name="questions[${questionCount}][question_type]"
                            onchange="toggleOptions(${questionCount})"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            <option value="text">Text</option>
                            <option value="multiple_choice">Multiple Choice</option>
                            <option value="checkbox">Checkbox</option>
                            <option value="rating">Rating</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">
                            <input type="checkbox"
                                name="questions[${questionCount}][is_required]"
                                value="1">
                            Required
                        </label>
                    </div>

                    <div id="options-container-${questionCount}" style="display: none;">
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Options</label>
                            <div id="options-list-${questionCount}"></div>
                            <button type="button"
                                onclick="addOption(${questionCount})"
                                class="mt-2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded text-sm">
                                Add Option
                            </button>
                        </div>
                    </div>

                    <button type="button"
                        onclick="removeQuestion(${questionCount})"
                        class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded text-sm">
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
                        class="shadow appearance-none border rounded flex-1 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline mr-2"
                        placeholder="Option ${optionCount + 1}"
                        required>
                    <button type="button"
                        onclick="this.parentElement.remove()"
                        class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded text-sm">
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
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}
</style>
</x-app-layout>
