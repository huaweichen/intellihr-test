<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Questionnaire List') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if (empty($questionnaires))
                        <h1>There is no questionnaires for you to view.</h1>
                    @else
                        <table>
                            @foreach($questionnaires as $questionnaireId)
                                <tr>
                                    <td>
                                        <a class="underline text-sm text-gray-600 hover:text-gray-900"
                                           href="{{route('questionnaires.show', ['questionnaire' => $questionnaireId])}}">
                                            Navigate to Questionnaire {{ $questionnaireId }}
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
