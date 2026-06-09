<?php

namespace App\Http\Controllers;

use App\Models\Enseignant;
use App\Models\Heure;
use Illuminate\Http\Request;

class EnseignantController extends Controller
{
    public function index()
    {
        $enseignants = Enseignant::all();
        return view('Enseignants.enseignants', compact('enseignants'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nom' => 'required|string|max:255',
            'pourcentage' => 'required|numeric|min:0|max:100',
        ]);

        Enseignant::create($data);

        return redirect()->route('enseignants.index');
    }

    public function update(Request $request, Enseignant $enseignant)
    {
        $data = $request->validate([
            'nom' => 'required|string|max:255',
            'pourcentage' => 'required|numeric|min:0|max:100',
        ]);

        $enseignant->update($data);

        return redirect()->route('enseignants.index');
    }

    public function destroy(Enseignant $enseignant)
    {
        $enseignant->delete();

        return redirect()->route('enseignants.index');
    }

    // ================= SALAIRES =================
    public function salaires()
    {
        $enseignants = Enseignant::all();

        $totalEncaisseGlobal = 0;
        $totalSalaireGlobal = 0;

        foreach ($enseignants as $enseignant) {

            $totalEncaisse = Heure::whereHas('seance', function ($q) use ($enseignant) {
                    $q->where('enseignant_id', $enseignant->id);
                })
                ->where('statut_paiement', 'payé')
                ->sum('montant');

            $salaire = $totalEncaisse * ($enseignant->pourcentage / 100);
            $centre = $totalEncaisse - $salaire;

            $enseignant->total_encaisse = $totalEncaisse;
            $enseignant->salaire = $salaire;
            $enseignant->centre = $centre;

            $totalEncaisseGlobal += $totalEncaisse;
            $totalSalaireGlobal += $salaire;
        }

        return view('Enseignants.salaires', [
            'enseignants' => $enseignants,
            'totalEncaisseGlobal' => $totalEncaisseGlobal,
            'totalSalaireGlobal' => $totalSalaireGlobal,
            'centreGlobal' => $totalEncaisseGlobal - $totalSalaireGlobal
        ]);
    }
}