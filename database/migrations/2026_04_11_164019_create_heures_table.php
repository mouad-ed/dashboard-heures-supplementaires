<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('heures', function (Blueprint $table) {
            $table->id();

            // relations
            $table->foreignId('seance_id')->constrained()->cascadeOnDelete();
            $table->foreignId('eleve_id')->constrained()->cascadeOnDelete();

            // data
            $table->float('heures');
            $table->decimal('montant', 8, 2);

            // statut propre
            $table->enum('statut_paiement', [
                'en_attente',
                'paye',
                'en_retard'
            ])->default('en_attente');

            // date
            $table->date('date_paiement')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('heures');
    }
};