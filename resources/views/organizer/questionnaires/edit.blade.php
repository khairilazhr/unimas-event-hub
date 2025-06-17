<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Edit Questionnaire') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('organizer.questionnaires.update', $questionnaire) }}" method="POST" id="questionnaireForm">
                        @csrf
                        @method('PUT')

                        <!-- Basic Information -->
                        <div class="mb-6">
                            <label for="title" class="block mb-2 text-sm font-medium text-gray-700">Title</label>
                            <input type="text" name="title" id="title" class="w-full rounded-md"
                                value="{{ old('title', $questionnaire->title) }}" required>
                            @error('title')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="description" class="block mb-2 text-sm font-medium text-gray-700">Description</label>
                            <textarea name="description" id="description" rows="3" class="w-full rounded-md">{{ old('description', $questionnaire->description) }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="event_id" class="block mb-2 text-sm font-medium text-gray-700">Event</label>
                            <select name="event_id" id="event_id" class="w-full rounded-md" required>
                                <option value="">Select an event</option>
                                @foreach($events as $event)
                                    <option value="{{ $event->id }}" {{ old('event_id', $questionnaire->event_id) == $event->id ? 'selected' : '' }}>
                                        {{ $event->name }} ({{ \Carbon\Carbon::parse($event->date)->format('Y-m-d') }})
                                    </option>
                                @endforeach
                            </select>
                            @error('event_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Questions Section -->
                        <div class="mb-6">
                            <h3 class="mb-4 text-lg font-medium">Questions</h3>
                            <div id="questions-container">
                                @foreach($questionnaire->questions as $index => $question)
                                    <div class="p-4 mb-4 border rounded question-block">
                                        <input type="hidden" name="questions[{{ $index }}][id]" value="{{ $question->id }}">

                                        <div class="mb-3">
                                            <label class="block mb-2 text-sm font-medium text-gray-700">Question Text</label>
                                            <input type="text" name="questions[{{ $index }}][question_text]"
                                                class="w-full rounded-md" value="{{ $question->question_text }}" required>
                                        </div>

                                        <div class="mb-3">
                                            <label class="block mb-2 text-sm font-medium text-gray-700">Question Type</label>
                                            <select name="questions[{{ $index }}][question_type]" class="w-full rounded-md question-type" required>
                                                <option value="text" {{ $question->question_type == 'text' ? 'selected' : '' }}>Text</option>
                                                <option value="multiple_choice" {{ $question->question_type == 'multiple_choice' ? 'selected' : '' }}>Multiple Choice</option>
                                                <option value="checkbox" {{ $question->question_type == 'checkbox' ? 'selected' : '' }}>Checkbox</option>
                                                <option value="rating" {{ $question->question_type == 'rating' ? 'selected' : '' }}>Rating</option>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label class="inline-flex items-center">
                                                <input type="checkbox" name="questions[{{ $index }}][is_required]"
                                                    class="rounded" {{ $question->is_required ? 'checked' : '' }}>
                                                <span class="ml-2 text-sm">Required</span>
                                            </label>
                                        </div>

                                        <div class="options-container {{ in_array($question->question_type, ['multiple_choice', 'checkbox']) ? '' : 'hidden' }}">
                                            <label class="block mb-2 text-sm font-medium text-gray-700">Options</label>
                                            <div class="options-list">
                                                @foreach($question->options as $option)
                                                    <div class="flex mb-2 option-row">
                                                        <input type="text" name="questions[{{ $index }}][options][]"
                                                            class="flex-1 rounded-md" value="{{ $option->option_text }}">
                                                        <button type="button" class="px-2 ml-2 text-red-600 remove-option">&times;</button>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <button type="button" class="px-3 py-1 mt-2 text-sm text-white bg-blue-500 rounded add-option">
                                                Add Option
                                            </button>
                                        </div>

                                        <button type="button" class="px-3 py-1 mt-3 text-sm text-white bg-red-500 rounded remove-question">
                                            Remove Question
                                        </button>
                                    </div>
                                @endforeach
                            </div>

                            <button type="button" id="add-question" class="px-4 py-2 text-white bg-green-500 rounded">
                                Add Question
                            </button>
                        </div>

                        <div class="flex justify-end mt-6">
                            <button type="submit" class="px-4 py-2 text-white bg-blue-500 rounded hover:bg-blue-600">
                                Update Questionnaire
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let questionCounter = {{ $questionnaire->questions->count() }};

            // Add Question
            document.getElementById('add-question').addEventListener('click', function() {
                const template = `
                    <div class="p-4 mb-4 border rounded question-block">
                        <div class="mb-3">
                            <label class="block mb-2 text-sm font-medium text-gray-700">Question Text</label>
                            <input type="text" name="questions[${questionCounter}][question_text]" class="w-full rounded-md" required>
                        </div>

                        <div class="mb-3">
                            <label class="block mb-2 text-sm font-medium text-gray-700">Question Type</label>
                            <select name="questions[${questionCounter}][question_type]" class="w-full rounded-md question-type" required>
                                <option value="text">Text</option>
                                <option value="multiple_choice">Multiple Choice</option>
                                <option value="checkbox">Checkbox</option>
                                <option value="rating">Rating</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="questions[${questionCounter}][is_required]" class="rounded">
                                <span class="ml-2 text-sm">Required</span>
                            </label>
                        </div>

                        <div class="hidden options-container">
                            <label class="block mb-2 text-sm font-medium text-gray-700">Options</label>
                            <div class="options-list">
                                <div class="flex mb-2 option-row">
                                    <input type="text" name="questions[${questionCounter}][options][]" class="flex-1 rounded-md">
                                    <button type="button" class="px-2 ml-2 text-red-600 remove-option">&times;</button>
                                </div>
                            </div>
                            <button type="button" class="px-3 py-1 mt-2 text-sm text-white bg-blue-500 rounded add-option">
                                Add Option
                            </button>
                        </div>

                        <button type="button" class="px-3 py-1 mt-3 text-sm text-white bg-red-500 rounded remove-question">
                            Remove Question
                        </button>
                    </div>
                `;

                document.getElementById('questions-container').insertAdjacentHTML('beforeend', template);
                questionCounter++;
            });

            // Handle question type changes
            document.addEventListener('change', function(e) {
                if (e.target.classList.contains('question-type')) {
                    const optionsContainer = e.target.closest('.question-block').querySelector('.options-container');
                    if (['multiple_choice', 'checkbox'].includes(e.target.value)) {
                        optionsContainer.classList.remove('hidden');
                    } else {
                        optionsContainer.classList.add('hidden');
                    }
                }
            });

            // Add Option
            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('add-option')) {
                    const optionsList = e.target.previousElementSibling;
                    const questionIndex = e.target.closest('.question-block').querySelector('input[name*="[question_text]"]')
                        .name.match(/questions\[(\d+)\]/)[1];

                    const optionTemplate = `
                        <div class="flex mb-2 option-row">
                            <input type="text" name="questions[${questionIndex}][options][]" class="flex-1 rounded-md">
                            <button type="button" class="px-2 ml-2 text-red-600 remove-option">&times;</button>
                        </div>
                    `;

                    optionsList.insertAdjacentHTML('beforeend', optionTemplate);
                }
            });

            // Remove Option
            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('remove-option')) {
                    e.target.closest('.option-row').remove();
                }
            });

            // Remove Question
            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('remove-question')) {
                    e.target.closest('.question-block').remove();
                }
            });
        });
    </script>
    @endpush
</x-app-layout>
