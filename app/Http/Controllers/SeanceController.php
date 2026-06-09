<?php

namespace App\Http\Controllers;

use App\Models\Seance;
use App\Models\Enseignant;
use Illuminate\Http\Request;

class SeanceController extends Controller
{
    public function index()
    {
        $seances = Seance::with('enseignant')->latest()->get();
        $enseignants = Enseignant::all();

        return view('seances.seances', compact('seances', 'enseignants'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required',
            'groupe' => 'required',
            'enseignant_id' => 'required|exists:enseignants,id',
            'prix_heure' => 'required|numeric',
        ]);

        Seance::create($data);

        return back()->with('success', 'Séance ajoutée avec succès');
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required',
            'groupe' => 'required',
            'enseignant_id' => 'required|exists:enseignants,id',
            'prix_heure' => 'required|numeric',
        ]);

        $seance = Seance::findOrFail($id);
        $seance->update($data);

        return back()->with('success', 'Séance modifiée avec succès');
    }

    public function destroy($id)
    {
        Seance::findOrFail($id)->delete();

        return back()->with('success', 'Séance supprimée avec succès');
    }
}