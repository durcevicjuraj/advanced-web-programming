<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            My Tasks
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @forelse($tasks as $task)
                        <div class="mb-6 p-4 border rounded-lg">
                            <h3 class="text-lg font-semibold mb-2">
                                @if(app()->getLocale() == 'en')
                                    {{ $task->naziv_rada_en }}
                                @else
                                    {{ $task->naziv_rada }}
                                @endif
                            </h3>
                            <p class="text-gray-600 mb-2">{{ $task->zadatak_rada }}</p>
                            <p class="text-sm text-gray-500 mb-3">
                                {{ __('messages.study_type') }}: {{ __('messages.' . $task->tip_studija) }}
                            </p>

                            @if($task->accepted_student_id)
                                <div class="mb-3 p-3 bg-green-50 border border-green-200 rounded">
                                    <p class="text-sm text-green-800">
                                        <strong>Accepted:</strong> {{ $task->acceptedStudent->name }}
                                    </p>
                                </div>
                            @else
                                <div class="mt-4">
                                    <h4 class="font-semibold mb-2">Applicants:</h4>
                                    @forelse($task->applicants as $applicant)
                                        <div class="flex items-center justify-between p-2 bg-gray-50 rounded mb-2">
                                            <span>{{ $applicant->name }} ({{ $applicant->email }}) - Priority: {{ $applicant->pivot->priority }}</span>
                                            <form action="{{ route('tasks.acceptStudent', [$task, $applicant->id]) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700">
                                                    Accept
                                                </button>
                                            </form>
                                        </div>
                                    @empty
                                        <p class="text-gray-500 text-sm">No applicants yet</p>
                                    @endforelse
                                </div>
                            @endif
                        </div>
                    @empty
                        <p class="text-gray-500">No tasks yet. <a href="{{ route('tasks.create') }}" class="text-blue-600">Create one</a></p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>