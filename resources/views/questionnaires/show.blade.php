<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Questionnaire') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('submissions.store') }}">
                        @csrf
                        <h1>Questionnaire ID: {{ $questionnaireId }}</h1>
                        <x-input
                            class="hidden"
                            type="text"
                            name="questionnaire_id"
                            :value="$questionnaireId"
                        />
                        <div>
                            @foreach ($questions as $question)
                                <x-label for="{{ $question['question_id'] }}" :value="__($question['label'])"/>
                                @if ($question['type'] === 'text')
                                    <x-input
                                        id="{{ $question['question_id'] }}"
                                        class="block mt-1 w-full"
                                        type="text"
                                        name="question[{{ $question['question_id'] }}]"
                                        :required="$question['required'] === 1"
                                        autofocus
                                    />
                                @elseif($question['type'] === 'select')
                                    <x-select
                                        :id="$question['question_id']"
                                        :options="$question['options']"
                                        name="question[{{$question['question_id']}}]"
                                    />
                                @endif
                            @endforeach
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a class="underline text-sm text-gray-600 hover:text-gray-900"
                               href="{{route('questionnaires.index')}}">
                                Back to Questionnaire List
                            </a>
                            <x-button class="ml-3">
                                {{ __('Submit') }}
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
