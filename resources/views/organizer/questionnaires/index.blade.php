<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Questionnaires') }}
            </h2>
            <a href="{{ route('organizer.questionnaires.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Create New Questionnaire
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if($questionnaires->isEmpty())
                        <p class="text-gray-500 text-center">No questionnaires created yet.</p>
                    @else
                        <div class="grid gap-4">
                            @foreach($questionnaires as $questionnaire)
                                <div class="border p-4 rounded-lg shadow">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h3 class="text-lg font-semibold">{{ $questionnaire->title }}</h3>
                                            <p class="text-sm text-gray-600">Event: {{ $questionnaire->event->name }}</p>
                                            <p class="text-sm text-gray-500">Status: {{ ucfirst($questionnaire->status) }}</p>
                                        </div>
                                        <div class="flex space-x-2">
                                            <a href="{{ route('organizer.questionnaires.edit', $questionnaire) }}"
                                               class="text-blue-600 hover:text-blue-800">Edit</a>
                                            @if($questionnaire->status === 'draft')
                                                <form action="{{ route('organizer.questionnaires.publish', $questionnaire) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="text-green-600 hover:text-green-800">Publish</button>
                                                </form>
                                            @endif
                                            <form action="{{ route('organizer.questionnaires.destroy', $questionnaire) }}" method="POST"
                                                  onsubmit="return confirm('Are you sure you want to delete this questionnaire?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-800">Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
