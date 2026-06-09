<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Heure extends Model
{
    protected $table = 'heures';

    protected $fillable = [
        'eleve_id',
        'seance_id',
        'heures',
        'montant',
        'statut_paiement',
        'date_paiement',
    ];

    // ================= RELATION: Eleve =================
    public function eleve()
    {
        return $this->belongsTo(Eleve::class);
    }

    // ================= RELATION: Seance =================
    public function seance()
    {
        return $this->belongsTo(Seance::class);
    }
    public function paiements()
    {
        return $this->hasMany(Paiement::class);
    }
}