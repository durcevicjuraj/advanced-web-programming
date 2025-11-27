<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $project->naziv_projekta }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="mb-6">
                        <h3 class="text-lg font-semibold mb-2">Detalji projekta:</h3>
                        
                        <div class="mb-3">
                            <span class="font-semibold">Naziv:</span> {{ $project->naziv_projekta }}
                        </div>

                        <div class="mb-3">
                            <span class="font-semibold">Opis:</span>
                            <p class="mt-1">{{ $project->opis_projekta }}</p>
                        </div>

                        <div class="mb-3">
                            <span class="font-semibold">Cijena:</span> {{ $project->cijena_projekta }} EUR
                        </div>

                        <div class="mb-3">
                            <span class="font-semibold">Obavljeni poslovi:</span>
                            <p class="mt-1">{{ $project->obavljeni_poslovi ?? 'Nema unesenih poslova' }}</p>
                        </div>

                        <div class="mb-3">
                            <span class="font-semibold">Datum početka:</span> {{ $project->datum_pocetka }}
                        </div>

                        <div class="mb-3">
                            <span class="font-semibold">Datum završetka:</span> {{ $project->datum_zavrsetka ?? 'Nije određen' }}
                        </div>

                        <div class="mb-3">
                            <span class="font-semibold">Voditelj projekta:</span> {{ $project->voditelj->name }}
                        </div>

                        <div class="mb-3">
                            <span class="font-semibold">Članovi tima:</span>
                            @if($project->clanovi->count() > 0)
                                <ul class="list-disc list-inside mt-1">
                                    @foreach($project->clanovi as $clan)
                                        <li>{{ $clan->name }}</li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="mt-1 text-gray-500">Nema dodanih članova tima</p>
                            @endif
                        </div>
                    </div>

                    <div class="flex items-center space-x-3">
                        <a href="{{ route('projects.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Natrag
                        </a>
                        
                        <a href="{{ route('projects.edit', $project) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                            Uredi
                        </a>

                        @if($project->user_id === auth()->id())
                            <form method="POST" action="{{ route('projects.destroy', $project) }}" onsubmit="return confirm('Jeste li sigurni da želite obrisati ovaj projekt?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                    Obriši
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>