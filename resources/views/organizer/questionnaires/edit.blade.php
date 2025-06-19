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
                                Edit Questionnaire
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
                        <form action="{{ route('organizer.questionnaires.update', $questionnaire) }}" method="POST"
                            id="questionnaireForm">
                            @csrf
                            @method('PUT')
                            <!-- Display any validation errors -->
                            @if ($errors->any())
                                <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                                    <p><strong>Validation Errors:</strong></p>
                                    <ul class="list-disc list-inside">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <!-- Basic Information Card -->
                            <div
                                class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl shadow-sm mb-6">
                                <div class="p-6">
                                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Basic
                                        Information</h2>

                                    <div class="grid gap-6 mb-6">
                                        <div>
                                            <label for="title"
                                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Title</label>
                                            <input type="text" name="title" id="title"
                                                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-unimasblue focus:ring focus:ring-unimasblue focus:ring-opacity-50"
                                                value="{{ old('title', $questionnaire->title) }}" required>
                                            @error('title')
                                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}
                                                </p>
                                            @enderror
                                        </div>

                                        <div>
                                            <label for="description"
                                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Description</label>
                                            <textarea name="description" id="description" rows="3"
                                                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-unimasblue focus:ring focus:ring-unimasblue focus:ring-opacity-50">{{ old('description', $questionnaire->description) }}</textarea>
                                            @error('description')
                                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}
                                                </p>
                                            @enderror
                                        </div>

                                        <div>
                                            <label for="event_id"
                                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Event</label>
                                            <select name="event_id" id="event_id"
                                                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-unimasblue focus:ring focus:ring-unimasblue focus:ring-opacity-50"
                                                required>
                                                <option value="">Select an event</option>
                                                @foreach ($events as $event)
                                                    <option value="{{ $event->id }}"
                                                        {{ old('event_id', $questionnaire->event_id) == $event->id ? 'selected' : '' }}>
                                                        {{ $event->name }}
                                                        ({{ Carbon\Carbon::parse($event->date)->format('Y-m-d') }})
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('event_id')
                                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}
                                                </p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Questions Section -->
                            <div
                                class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl shadow-sm mb-6">
                                <div class="p-6">
                                    <div class="flex justify-between items-center mb-4">
                                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Questions
                                        </h2>
                                        <button type="button" id="add-question"
                                            class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-lg text-white bg-unimasblue hover:bg-blue-600 transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 4v16m8-8H4" />
                                            </svg>
                                            Add Question
                                        </button>
                                    </div>
                                    <div id="questions-container" class="space-y-4">
                                        @foreach ($questionnaire->questions as $index => $question)
                                            <div
                                                class="bg-gray-50 dark:bg-gray-700/50 border border-gray-200 dark:border-gray-600 rounded-lg p-4 question-block">
                                                <input type="hidden" name="questions[{{ $index }}][id]"
                                                    value="{{ $question->id }}">

                                                <div class="grid gap-4">
                                                    <div>
                                                        <label
                                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Question
                                                            Text</label>
                                                        <input type="text"
                                                            name="questions[{{ $index }}][question_text]"
                                                            class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-unimasblue focus:ring focus:ring-unimasblue focus:ring-opacity-50"
                                                            value="{{ $question->question_text }}" required>
                                                    </div>

                                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                                        <div>
                                                            <label
                                                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Question
                                                                Type</label>
                                                            <select
                                                                name="questions[{{ $index }}][question_type]"
                                                                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-unimasblue focus:ring focus:ring-unimasblue focus:ring-opacity-50 question-type"
                                                                required>
                                                                <option value="text"
                                                                    {{ $question->question_type == 'text' ? 'selected' : '' }}>
                                                                    Text</option>
                                                                <option value="multiple_choice"
                                                                    {{ $question->question_type == 'multiple_choice' ? 'selected' : '' }}>
                                                                    Multiple Choice</option>
                                                                <option value="checkbox"
                                                                    {{ $question->question_type == 'checkbox' ? 'selected' : '' }}>
                                                                    Checkbox</option>
                                                                <option value="rating"
                                                                    {{ $question->question_type == 'rating' ? 'selected' : '' }}>
                                                                    Rating</option>
                                                            </select>
                                                        </div>

                                                        <div>
                                                            <label
                                                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">&nbsp;</label>
                                                            <label class="inline-flex items-center">
                                                                <input type="hidden"
                                                                    name="questions[{{ $index }}][is_required]"
                                                                    value="0">
                                                                <input type="checkbox"
                                                                    name="questions[{{ $index }}][is_required]"
                                                                    value="1"
                                                                    class="rounded border-gray-300 dark:border-gray-600 text-unimasblue shadow-sm focus:border-unimasblue focus:ring focus:ring-unimasblue focus:ring-opacity-50"
                                                                    {{ $question->is_required ? 'checked' : '' }}>
                                                                <span
                                                                    class="ml-2 text-sm text-gray-600 dark:text-gray-400">Required</span>
                                                            </label>
                                                        </div>
                                                    </div>

                                                    <div
                                                        class="options-container {{ in_array($question->question_type, ['multiple_choice', 'checkbox']) ? '' : 'hidden' }}">
                                                        <label
                                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Options</label>
                                                        <div class="options-list space-y-2">
                                                            @foreach ($question->options as $option)
                                                                <div class="flex items-center option-row">
                                                                    <input type="text"
                                                                        name="questions[{{ $index }}][options][]"
                                                                        class="flex-1 rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-unimasblue focus:ring focus:ring-unimasblue focus:ring-opacity-50"
                                                                        value="{{ $option->option_text }}">
                                                                    <button type="button"
                                                                        class="ml-2 text-red-600 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300 remove-option">
                                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                                            class="h-5 w-5" fill="none"
                                                                            viewBox="0 0 24 24" stroke="currentColor">
                                                                            <path stroke-linecap="round"
                                                                                stroke-linejoin="round"
                                                                                stroke-width="2"
                                                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                                        </svg>
                                                                    </button>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                        <button type="button"
                                                            class="mt-2 inline-flex items-center px-3 py-1.5 text-sm font-medium rounded-lg text-unimasblue bg-blue-50 hover:bg-blue-100 dark:text-blue-400 dark:bg-blue-900/20 dark:hover:bg-blue-900/30 transition-colors add-option">
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                class="h-4 w-4 mr-1.5" fill="none"
                                                                viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2" d="M12 4v16m8-8H4" />
                                                            </svg>
                                                            Add Option
                                                        </button>
                                                    </div>

                                                    <div class="flex justify-end">
                                                        <button type="button"
                                                            class="inline-flex items-center px-3 py-1.5 text-sm font-medium rounded-lg text-red-600 bg-red-50 hover:bg-red-100 dark:text-red-400 dark:bg-red-900/20 dark:hover:bg-red-900/30 transition-colors remove-question">
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                class="h-4 w-4 mr-1.5" fill="none"
                                                                viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                            </svg>
                                                            Remove Question
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <div class="flex justify-end gap-4">
                                <a href="{{ route('organizer.questionnaires.index') }}"
                                    class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-lg text-gray-700 bg-gray-100 hover:bg-gray-200 dark:text-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 transition-colors">
                                    Cancel
                                </a>
                                <button type="submit"
                                    class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-lg text-white bg-unimasblue hover:bg-blue-600 transition-colors">
                                    Update Questionnaire
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

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                let questionCounter = {{ $questionnaire->questions->count() }};

                // Form submission debugging
                document.getElementById('questionnaireForm').addEventListener('submit', function(e) {
                    console.log('Form submission started');
                    console.log('Form action:', this.action);
                    console.log('Form method:', this.method);

                    // Log form data
                    const formData = new FormData(this);
                    for (let [key, value] of formData.entries()) {
                        console.log(key + ': ' + value);
                    }

                    // Check if there are any validation errors
                    const requiredFields = this.querySelectorAll('[required]');
                    let hasErrors = false;
                    requiredFields.forEach(field => {
                        if (!field.value.trim()) {
                            console.error('Required field empty:', field.name);
                            hasErrors = true;
                        }
                    });

                    if (hasErrors) {
                        console.error('Form has validation errors, preventing submission');
                        e.preventDefault();
                        return false;
                    }

                    console.log('Form validation passed, proceeding with submission');
                });

                // Add Question handler
                document.getElementById('add-question').addEventListener('click', function() {
                    const template = `
                    <div class="bg-gray-50 dark:bg-gray-700/50 border border-gray-200 dark:border-gray-600 rounded-lg p-4 question-block">
                        <div class="grid gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Question Text</label>
                                <input type="text" name="questions[${questionCounter}][question_text]" 
                                    class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-unimasblue focus:ring focus:ring-unimasblue focus:ring-opacity-50" 
                                    required>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Question Type</label>
                                    <select name="questions[${questionCounter}][question_type]" 
                                        class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-unimasblue focus:ring focus:ring-unimasblue focus:ring-opacity-50 question-type" 
                                        required>
                                        <option value="text">Text</option>
                                        <option value="multiple_choice">Multiple Choice</option>
                                        <option value="checkbox">Checkbox</option>
                                        <option value="rating">Rating</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">&nbsp;</label>
                                    <label class="inline-flex items-center">
                                        <input type="hidden" name="questions[${questionCounter}][is_required]" value="0">
                                        <input type="checkbox" name="questions[${questionCounter}][is_required]" value="1" 
                                            class="rounded border-gray-300 dark:border-gray-600 text-unimasblue shadow-sm focus:border-unimasblue focus:ring focus:ring-unimasblue focus:ring-opacity-50">
                                        <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">Required</span>
                                    </label>
                                </div>
                            </div>

                            <div class="hidden options-container">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Options</label>
                                <div class="options-list space-y-2">
                                    <div class="flex items-center option-row">
                                        <input type="text" name="questions[${questionCounter}][options][]" 
                                            class="flex-1 rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-unimasblue focus:ring focus:ring-unimasblue focus:ring-opacity-50">
                                        <button type="button" class="ml-2 text-red-600 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300 remove-option">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                <button type="button" class="mt-2 inline-flex items-center px-3 py-1.5 text-sm font-medium rounded-lg text-unimasblue bg-blue-50 hover:bg-blue-100 dark:text-blue-400 dark:bg-blue-900/20 dark:hover:bg-blue-900/30 transition-colors add-option">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                    Add Option
                                </button>
                            </div>

                            <div class="flex justify-end">
                                <button type="button" class="inline-flex items-center px-3 py-1.5 text-sm font-medium rounded-lg text-red-600 bg-red-50 hover:bg-red-100 dark:text-red-400 dark:bg-red-900/20 dark:hover:bg-red-900/30 transition-colors remove-question">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    Remove Question
                                </button>
                            </div>
                        </div>
                    </div>
                `;

                    document.getElementById('questions-container').insertAdjacentHTML('beforeend', template);
                    questionCounter++;
                });

                // Question type change handler
                document.addEventListener('change', function(e) {
                    if (e.target.classList.contains('question-type')) {
                        const optionsContainer = e.target.closest('.question-block').querySelector(
                            '.options-container');
                        if (['multiple_choice', 'checkbox'].includes(e.target.value)) {
                            optionsContainer.classList.remove('hidden');
                        } else {
                            optionsContainer.classList.add('hidden');
                        }
                    }
                });

                // Add Option handler
                document.addEventListener('click', function(e) {
                    if (e.target.classList.contains('add-option') || e.target.closest('.add-option')) {
                        console.log('Add Option button clicked');

                        const button = e.target.classList.contains('add-option') ? e.target : e.target.closest(
                            '.add-option');
                        const optionsList = button.previousElementSibling;

                        console.log('Options list found:', optionsList);

                        // Get the question index from the question block
                        const questionBlock = button.closest('.question-block');
                        const questionTextInput = questionBlock.querySelector('input[name*="[question_text]"]');
                        let questionIndex = 0;

                        console.log('Question text input found:', questionTextInput);

                        if (questionTextInput) {
                            const match = questionTextInput.name.match(/questions\[(\d+)\]/);
                            if (match) {
                                questionIndex = match[1];
                                console.log('Question index extracted:', questionIndex);
                            }
                        }

                        const template = `
                        <div class="flex items-center option-row">
                            <input type="text" name="questions[${questionIndex}][options][]" 
                                class="flex-1 rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-unimasblue focus:ring focus:ring-unimasblue focus:ring-opacity-50">
                            <button type="button" class="ml-2 text-red-600 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300 remove-option">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </div>
                    `;

                        console.log('Adding template:', template);
                        optionsList.insertAdjacentHTML('beforeend', template);
                        console.log('Template added successfully');
                    }
                });

                // Remove Option handler
                document.addEventListener('click', function(e) {
                    if (e.target.classList.contains('remove-option') || e.target.closest('.remove-option')) {
                        const button = e.target.classList.contains('remove-option') ? e.target : e.target
                            .closest('.remove-option');
                        button.closest('.option-row').remove();
                    }
                });

                // Remove Question handler
                document.addEventListener('click', function(e) {
                    if (e.target.classList.contains('remove-question') || e.target.closest(
                            '.remove-question')) {
                        const button = e.target.classList.contains('remove-question') ? e.target : e.target
                            .closest('.remove-question');
                        button.closest('.question-block').remove();
                    }
                });
            });
        </script>
    @endpush
</x-app-layout>
