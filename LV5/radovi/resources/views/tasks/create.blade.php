<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('messages.add_task') }}
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
                    <form action="{{ route('tasks.store') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-2">{{ __('messages.task_title') }}</label>
                            <input type="text" name="naziv_rada" class="w-full rounded border-gray-300" required>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-2">{{ __('messages.task_title_en') }}</label>
                            <input type="text" name="naziv_rada_en" class="w-full rounded border-gray-300" required>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-2">{{ __('messages.task_description') }}</label>
                            <textarea name="zadatak_rada" rows="4" class="w-full rounded border-gray-300" required></textarea>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-2">{{ __('messages.study_type') }}</label>
                            <select name="tip_studija" class="w-full rounded border-gray-300" required>
                                <option value="strucni">{{ __('messages.strucni') }}</option>
                                <option value="preddiplomski">{{ __('messages.preddiplomski') }}</option>
                                <option value="diplomski">{{ __('messages.diplomski') }}</option>
                            </select>
                        </div>

                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">{{ __('messages.create') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>