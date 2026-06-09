<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enseignant extends Model
{
    use HasFactory;
    protected $fillable = ['nom', 'pourcentage'];

public function seances()
{
    return $this->hasMany(Seance::class);
}
}


