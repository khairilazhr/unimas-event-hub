<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Questionnaire') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('organizer.questionnaires.update', $questionnaire) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <!-- Similar to create.blade.php but with values pre-filled -->
                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Title</label>
                                <input type="text" name="title" required value="{{ $questionnaire->title }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            </div>

                            <!-- Add rest of the form similar to create.blade.php -->
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>