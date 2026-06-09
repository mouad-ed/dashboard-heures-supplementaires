<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seance extends Model
{
    protected $fillable = [
        'date',
        'start_time',
        'end_time',
        'groupe',
        'enseignant_id',
        'prix_heure',
    ];

    public function enseignant()
    {
        return $this->belongsTo(Enseignant::class);
    }

    public function heures()
    {
        return $this->hasMany(HeuresSupplementaire::class);
    }
}