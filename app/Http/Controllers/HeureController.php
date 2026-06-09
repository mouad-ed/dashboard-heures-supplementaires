<?php

namespace App\Http\Controllers;

use App\Models\Heure;
use App\Models\Seance;
use App\Models\Eleve;
use Illuminate\Http\Request;

class HeureController extends Controller
{
    public function index()
    {
        $heures = Heure::with(['seance.enseignant', 'eleve'])
            ->latest()
            ->get();

        $total_heures = $heures->sum('heures');
        $total_paye = $heures->where('statut_paiement', 'paye')->sum('montant');
        $total_attente = $heures->where('statut_paiement', 'en_attente')->sum('montant');

        $seances = Seance::with('enseignant')->get();
        $eleves = Eleve::all();

        return view('heures.index', compact(
            'heures',
            'total_heures',
            'total_paye',
            'total_attente',
            'seances',
            'eleves'
        ));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'seance_id' => 'required|exists:seances,id',
            'eleve_id' => 'required|exists:eleves,id',
            'heures' => 'required|numeric|min:0.5',
            'statut_paiement' => 'required|in:en_attente,paye,en_retard',
            'date_paiement' => 'nullable|date',
        ]);

        // ✅ جلب séance
        $seance = Seance::findOrFail($data['seance_id']);

        // ✅ حساب montant من prix_heure ديال séance
        $data['montant'] = $data['heures'] * $seance->prix_heure;

        Heure::create($data);

        return back()->with('success', 'Ajouté avec succès');
    }

    public function update(Request $request, Heure $heure)
    {
        $data = $request->validate([
            'seance_id' => 'required|exists:seances,id',
            'eleve_id' => 'required|exists:eleves,id',
            'heures' => 'required|numeric|min:0.5',
            'statut_paiement' => 'required|in:en_attente,paye,en_retard',
            'date_paiement' => 'nullable|date',
        ]);

        // ✅ جلب séance
        $seance = Seance::findOrFail($data['seance_id']);

        // ✅ recalcul montant
        $data['montant'] = $data['heures'] * $seance->prix_heure;

        $heure->update($data);

        return back()->with('success', 'Modifié avec succès');
    }

    public function destroy(Heure $heure)
    {
        $heure->delete();

        return back()->with('success', 'Supprimé avec succès');
    }
}