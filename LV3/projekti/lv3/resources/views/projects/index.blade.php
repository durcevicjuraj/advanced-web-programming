<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Moji Projekti') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-4">
                        <a href="{{ route('projects.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Novi Projekt
                        </a>
                    </div>

                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    <h3 class="text-lg font-semibold mb-3">Projekti gdje sam voditelj:</h3>
                    @if($projektiVoditelj->count() > 0)
                        <div class="mb-6">
                            @foreach($projektiVoditelj as $projekt)
                                <div class="border p-4 mb-3 rounded">
                                    <h4 class="font-bold text-lg">{{ $projekt->naziv_projekta }}</h4>
                                    <p class="text-gray-600">{{ Str::limit($projekt->opis_projekta, 100) }}</p>
                                    <p class="text-sm text-gray-500 mt-2">Cijena: {{ $projekt->cijena_projekta }} EUR</p>
                                    <div class="mt-2">
                                        <a href="{{ route('projects.show', $projekt) }}" class="text-blue-500 hover:underline">Pogledaj</a>
                                        <a href="{{ route('projects.edit', $projekt) }}" class="text-yellow-500 hover:underline ml-3">Uredi</a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 mb-6">Nemate projekata gdje ste voditelj.</p>
                    @endif

                    <h3 class="text-lg font-semibold mb-3">Projekti gdje sam član tima:</h3>
                    @if($projektiClan->count() > 0)
                        <div>
                            @foreach($projektiClan as $projekt)
                                <div class="border p-4 mb-3 rounded">
                                    <h4 class="font-bold text-lg">{{ $projekt->naziv_projekta }}</h4>
                                    <p class="text-gray-600">{{ Str::limit($projekt->opis_projekta, 100) }}</p>
                                    <p class="text-sm text-gray-500 mt-2">Voditelj: {{ $projekt->voditelj->name }}</p>
                                    <div class="mt-2">
                                        <a href="{{ route('projects.show', $projekt) }}" class="text-blue-500 hover:underline">Pogledaj</a>
                                        <a href="{{ route('projects.edit', $projekt) }}" class="text-yellow-500 hover:underline ml-3">Uredi obavljene poslove</a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500">Niste član ni jednog projekta.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>