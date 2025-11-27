<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    // Prikaži sve projekte (voditelj i član)
    public function index()
    {
        $user = auth()->user();
        $projektiVoditelj = $user->projektiVoditelj;
        $projektiClan = $user->projektiClan;
        
        return view('projects.index', compact('projektiVoditelj', 'projektiClan'));
    }

    // Forma za kreiranje novog projekta
    public function create()
    {
        return view('projects.create');
    }

    // Spremi novi projekt
    public function store(Request $request)
    {
        $validated = $request->validate([
            'naziv_projekta' => 'required|string|max:255',
            'opis_projekta' => 'required|string',
            'cijena_projekta' => 'required|numeric',
            'datum_pocetka' => 'required|date',
            'datum_zavrsetka' => 'nullable|date|after:datum_pocetka',
        ]);

        $validated['user_id'] = auth()->id();
        
        Project::create($validated);

        return redirect()->route('projects.index')->with('success', 'Projekt uspješno kreiran!');
    }

    // Prikaži pojedinačni projekt
    public function show(Project $project)
    {
        return view('projects.show', compact('project'));
    }

    // Forma za uređivanje projekta
    public function edit(Project $project)
    {
        // Provjeri je li korisnik voditelj ili član
        $user = auth()->user();
        $jeVoditelj = $project->user_id === $user->id;
        $jeClan = $project->clanovi->contains($user->id);
        
        if (!$jeVoditelj && !$jeClan) {
            abort(403, 'Nemate pristup ovom projektu.');
        }

        $users = User::where('id', '!=', $project->user_id)->get();
        
        return view('projects.edit', compact('project', 'jeVoditelj', 'users'));
    }

    // Ažuriraj projekt
    public function update(Request $request, Project $project)
    {
        $user = auth()->user();
        $jeVoditelj = $project->user_id === $user->id;
        
        if ($jeVoditelj) {
            // Voditelj može mijenjati sve
            $validated = $request->validate([
                'naziv_projekta' => 'required|string|max:255',
                'opis_projekta' => 'required|string',
                'cijena_projekta' => 'required|numeric',
                'obavljeni_poslovi' => 'nullable|string',
                'datum_pocetka' => 'required|date',
                'datum_zavrsetka' => 'nullable|date|after:datum_pocetka',
            ]);
            
            $project->update($validated);
            
            // Ažuriraj članove
            if ($request->has('clanovi')) {
                $project->clanovi()->sync($request->clanovi);
            }
        } else {
            // Član može mijenjati samo obavljeni poslovi
            $validated = $request->validate([
                'obavljeni_poslovi' => 'nullable|string',
            ]);
            
            $project->update($validated);
        }

        return redirect()->route('projects.show', $project)->with('success', 'Projekt ažuriran!');
    }

    // Obriši projekt
    public function destroy(Project $project)
    {
        // Samo voditelj može obrisati projekt
        if ($project->user_id !== auth()->id()) {
            abort(403, 'Nemate pravo brisati ovaj projekt.');
        }
        
        $project->delete();

        return redirect()->route('projects.index')->with('success', 'Projekt obrisan!');
    }
}