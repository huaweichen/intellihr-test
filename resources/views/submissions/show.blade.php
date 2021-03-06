<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Submission') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h1>Questionnaire ID: </h1>
                    <p>{{ $questionnaireId }}</p>
                    <h1>Submission ID: </h1>
                    <p>{{ $submissionId }}</p>
                    <h1>User Subject ID: </h1>
                    <p>{{ $userSubjectId }}</p>
                    <h1>Date: </h1>
                    <p>{{ $date }}</p>
                    <hr>
                    <table>
                        <tr>
                            <th>Questions:</th>
                            <th>Responses:</th>
                        </tr>
                        @foreach($responses as $response)
                            <tr>
                                <td>{{ $response['label'] }}</td>
                                <td>{{ $response['response'] }}</td>
                            </tr>
                        @endforeach
                    </table>
                    <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('submissions.index') }}">Back to Submission List</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
