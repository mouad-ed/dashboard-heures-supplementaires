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
    Schema::table('salaires', function (Blueprint $table) {
        $table->decimal('salaire', 10, 2)->nullable();
        $table->decimal('part_centre', 10, 2)->nullable();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('salaires', function (Blueprint $table) {
            //
        });
    }
    
};
