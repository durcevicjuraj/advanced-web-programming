<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Novi Projekt') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('projects.store') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="naziv_projekta" class="block text-sm font-medium text-gray-700">Naziv projekta</label>
                            <input type="text" name="naziv_projekta" id="naziv_projekta" value="{{ old('naziv_projekta') }}" 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                            @error('naziv_projekta')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="opis_projekta" class="block text-sm font-medium text-gray-700">Opis projekta</label>
                            <textarea name="opis_projekta" id="opis_projekta" rows="4" 
                                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>{{ old('opis_projekta') }}</textarea>
                            @error('opis_projekta')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="cijena_projekta" class="block text-sm font-medium text-gray-700">Cijena projekta (EUR)</label>
                            <input type="number" step="0.01" name="cijena_projekta" id="cijena_projekta" value="{{ old('cijena_projekta') }}" 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                            @error('cijena_projekta')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="datum_pocetka" class="block text-sm font-medium text-gray-700">Datum početka</label>
                            <input type="date" name="datum_pocetka" id="datum_pocetka" value="{{ old('datum_pocetka') }}" 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                            @error('datum_pocetka')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="datum_zavrsetka" class="block text-sm font-medium text-gray-700">Datum završetka (opciono)</label>
                            <input type="date" name="datum_zavrsetka" id="datum_zavrsetka" value="{{ old('datum_zavrsetka') }}" 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            @error('datum_zavrsetka')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-between">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Kreiraj Projekt
                            </button>
                            <a href="{{ route('projects.index') }}" class="text-gray-600 hover:underline">Odustani</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>