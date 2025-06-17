<x-app-layout>
    <div class="flex flex-col min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800">
        {{-- Main Content --}}
        <main class="flex-grow py-6 sm:py-8 md:py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 shadow-lg sm:rounded-xl overflow-hidden">
                    <div class="relative bg-unimasblue dark:bg-unimasblue p-6">
                        <div class="absolute inset-0 opacity-10 bg-pattern-grid"></div>
                        <div class="flex justify-between items-center">
                            <h1 class="text-2xl sm:text-3xl font-bold text-white">
                                My Questionnaires
                            </h1>
                            <a href="{{ route('organizer.questionnaires.create') }}"
                               class="inline-flex items-center px-4 py-2 bg-white/10 hover:bg-white/20 text-white text-sm font-medium rounded-lg transition duration-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                                Create New Questionnaire
                            </a>
                        </div>
                    </div>

                    <div class="p-4 sm:p-6 md:p-8">
                        @if($questionnaires->isEmpty())
                            <div class="flex flex-col items-center justify-center py-12 text-center">
                                <div class="text-gray-400 dark:text-gray-500 mb-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                </div>
                                <p class="text-gray-600 dark:text-gray-300 text-lg font-medium mb-2">
                                    No questionnaires created yet
                                </p>
                                <p class="text-gray-500 dark:text-gray-400 mb-6">
                                    Create your first questionnaire to gather feedback from event participants
                                </p>
                                <a href="{{ route('organizer.questionnaires.create') }}"
                                   class="inline-flex items-center px-5 py-2.5 bg-unimasblue hover:bg-blue-600 text-white text-sm font-medium rounded-lg transition duration-300 shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                    Create Questionnaire
                                </a>
                            </div>
                        @else
                            <div class="grid gap-6 md:gap-8">
                                @foreach($questionnaires as $questionnaire)
                                    <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl shadow-sm hover:shadow-md transition-shadow duration-300">
                                        <div class="p-6">
                                            <div class="flex flex-col lg:flex-row min-h-[120px]">
                                                <!-- Left Content -->
                                                <div class="flex-1">
                                                    <div class="flex justify-between items-start mb-4">
                                                        <div class="flex-1 pr-4">
                                                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-1 truncate">
                                                                {{ $questionnaire->title }}
                                                            </h3>
                                                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                                                {{ $questionnaire->event->name }}
                                                            </p>
                                                        </div>
                                                        <div class="w-24 flex-shrink-0">
                                                            <span class="px-3 py-1 inline-flex justify-center w-full text-xs leading-5 font-semibold rounded-full
                                                                @if($questionnaire->published_at)
                                                                    bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100
                                                                @else
                                                                    bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100
                                                                @endif">
                                                                {{ $questionnaire->published_at ? 'Published' : 'Draft' }}
                                                            </span>
                                                        </div>
                                                    </div>

                                                    <!-- Questionnaire Details Grid -->
                                                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 text-sm">
                                                        <div>
                                                            <span class="block text-gray-500 dark:text-gray-400 font-medium">Questions</span>
                                                            <span class="text-gray-900 dark:text-white">
                                                                {{ $questionnaire->questions->count() }} questions
                                                            </span>
                                                        </div>
                                                        <div>
                                                            <span class="block text-gray-500 dark:text-gray-400 font-medium">Responses</span>
                                                            <span class="text-gray-900 dark:text-white">
                                                                {{ $questionnaire->questions->flatMap->responses->unique('user_id')->count() }} responses
                                                            </span>
                                                        </div>
                                                        <div>
                                                            <span class="block text-gray-500 dark:text-gray-400 font-medium">Last Updated</span>
                                                            <span class="text-gray-900 dark:text-white">
                                                                {{ $questionnaire->updated_at->diffForHumans() }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Right Content - Action Buttons -->
                                                <div class="lg:w-48 flex-shrink-0 lg:ml-6 mt-4 lg:mt-0">
                                                    <div class="flex flex-col gap-2">
                                                        <a href="{{ route('organizer.questionnaires.show', $questionnaire) }}"
                                                           class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium rounded-lg text-indigo-600 bg-indigo-50 hover:bg-indigo-100 dark:text-indigo-400 dark:bg-indigo-900/20 dark:hover:bg-indigo-900/30 transition-colors w-full">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                            </svg>
                                                            View Details
                                                        </a>

                                                        <a href="{{ route('organizer.questionnaires.edit', $questionnaire) }}"
                                                           class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium rounded-lg text-blue-600 bg-blue-50 hover:bg-blue-100 dark:text-blue-400 dark:bg-blue-900/20 dark:hover:bg-blue-900/30 transition-colors w-full">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                            </svg>
                                                            Edit
                                                        </a>

                                                        @if($questionnaire->published_at)
                                                            <a href="{{ route('organizer.questionnaires.responses', $questionnaire) }}"
                                                               class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium rounded-lg text-green-600 bg-green-50 hover:bg-green-100 dark:text-green-400 dark:bg-green-900/20 dark:hover:bg-green-900/30 transition-colors w-full">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                                </svg>
                                                                View Responses
                                                            </a>
                                                        @else
                                                            <form action="{{ route('organizer.questionnaires.publish', $questionnaire) }}" method="POST">
                                                                @csrf
                                                                <button type="submit"
                                                                        class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium rounded-lg text-green-600 bg-green-50 hover:bg-green-100 dark:text-green-400 dark:bg-green-900/20 dark:hover:bg-green-900/30 transition-colors w-full">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                                    </svg>
                                                                    Publish
                                                                </button>
                                                            </form>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </main>

        {{-- Footer component can be included here --}}
        <x-footer />
    </div>
</x-app-layout>
