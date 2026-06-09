<?php

namespace App\Http\Controllers;

use App\Models\Eleve;
use App\Models\Heure;
use App\Models\Salaire;

class DashboardController extends Controller
{
    public function index()
    {
        /*
        |-------------------------
        | TOTAL HEURES
        |-------------------------
        */
        $totalHours = Heure::sum('heures');

        /*
        |-------------------------
        | TOTAL ENCAISSÉ (from élèves)
        |-------------------------
        */
        $totalIncome = Heure::where('statut_paiement', 'paye')
            ->sum('montant');

        /*
        |-------------------------
        | ÉLÈVES NON PAYÉS
        |-------------------------
        */
        $unpaidStudents = Eleve::whereHas('heures', function ($q) {
            $q->whereIn('statut_paiement', ['en_attente', 'en_retard']);
        })->count();

        /*
        |-------------------------
        | SALAIRES À PAYER
        |-------------------------
        */
        $teachersDue = Salaire::where('statut', 'en_attente')
            ->sum('salaire');

        /*
        |-------------------------
        | HEURES PAR MOIS
        |-------------------------
        */
        $hours = Heure::selectRaw('MONTH(created_at) as month, SUM(heures) as total')
            ->groupBy('month')
            ->pluck('total', 'month');

        /*
        |-------------------------
        | REVENUS PAR MOIS
        |-------------------------
        */
        $revenues = Heure::selectRaw('MONTH(created_at) as month, SUM(montant) as total')
            ->where('statut_paiement', 'paye')
            ->groupBy('month')
            ->pluck('total', 'month');

        return view('dashboard', compact(
            'totalHours',
            'totalIncome',
            'unpaidStudents',
            'teachersDue',
            'revenues',
            'hours'
        ));
    }
}