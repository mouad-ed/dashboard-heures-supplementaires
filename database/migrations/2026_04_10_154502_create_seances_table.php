<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
    Schema::create('seances', function (Blueprint $table) {
        $table->id();
        $table->date('date');
        $table->string('horaire');
        $table->string('groupe');
        $table->foreignId('enseignant_id')->constrained()->cascadeOnDelete();
        $table->decimal('prix_heure', 8, 2);
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seances');
    }
};
