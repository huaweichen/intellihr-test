<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Submission List') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if (empty($submissions))
                        <h1>There is no submissions for you to view.</h1>
                    @else
                        @foreach($submissions as $index => $submission)
                            <h1><a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{route('submissions.show', ['submission' => $index])}}">Navigate
                                    to Submission {{ $index }}</a></h1>
                            <table>
                                <tr>
                                    <th>Questionnaire</th>
                                    <th>User</th>
                                    <th>Date</th>
                                    <th>Question ID</th>
                                    <th>Label</th>
                                    <th>Response</th>
                                </tr>
                                @foreach($submission as $record)
                                    <tr>
                                        <td>{{ $record['questionnaire'] }}</td>
                                        <td>{{ $record['user'] }}</td>
                                        <td>{{ $record['date'] }}</td>
                                        <td>{{ $record['question_id'] }}</td>
                                        <td>{{ $record['label'] }}</td>
                                        <td>{{ $record['response'] }}</td>
                                    </tr>
                                @endforeach
                            </table>
                            <hr>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
