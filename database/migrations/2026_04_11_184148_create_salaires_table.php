<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('salaires', function (Blueprint $table) {

            $table->id();

            // relation avec enseignant
            $table->foreignId('enseignant_id')
                  ->constrained()
                  ->cascadeOnDelete();

            // الشهر
            $table->string('mois'); // ex: mars 2026

            // total encaissé
            $table->decimal('total', 10, 2);

            // pourcentage enseignant
            $table->float('pourcentage')->default(50);

            // statut
            $table->enum('statut', ['en_attente', 'paye'])
                  ->default('en_attente');

            // date paiement
            $table->date('date_paiement')->nullable();

            $table->timestamps();

            // éviter doublon (enseignant + mois)
            $table->unique(['enseignant_id', 'mois']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('salaires');
    }
};