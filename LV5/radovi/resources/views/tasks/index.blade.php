<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Available Tasks
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
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
                            <p class="text-sm text-gray-500 mb-2">
                                {{ __('messages.study_type') }}: {{ __('messages.' . $task->tip_studija) }}
                            </p>
                            <p class="text-sm text-gray-500 mb-3">
                                Teacher: {{ $task->nastavnik->name }}
                            </p>

                            @if(auth()->user()->appliedTasks->contains($task->id))
    <form action="{{ route('tasks.cancel', $task) }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded">Cancel Application</button>
    </form>
@else
    <form action="{{ route('tasks.apply', $task) }}" method="POST" class="flex items-center space-x-2">
        @csrf
        <select name="priority" class="rounded border-gray-300" required>
            <option value="">Select Priority</option>
            <option value="1">Priority 1 (Highest)</option>
            <option value="2">Priority 2</option>
            <option value="3">Priority 3</option>
            <option value="4">Priority 4</option>
            <option value="5">Priority 5</option>
        </select>
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Apply</button>
    </form>
@endif
                        </div>
                    @empty
                        <p class="text-gray-500">No tasks available</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>