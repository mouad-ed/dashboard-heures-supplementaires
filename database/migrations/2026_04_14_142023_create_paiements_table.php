<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('paiements', function (Blueprint $table) {
            $table->id();

            $table->foreignId('heure_id')
                ->constrained('heures')
                ->onDelete('cascade');

            $table->decimal('montant', 8, 2);

            $table->enum('statut', ['paye', 'en_attente', 'en_retard'])
                ->default('en_attente');

            $table->date('paid_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('paiements');
    }
};
