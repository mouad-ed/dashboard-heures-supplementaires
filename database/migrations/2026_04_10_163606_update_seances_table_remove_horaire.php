<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up(): void
{
    if (Schema::hasColumn('seances', 'horaire')) {
        Schema::table('seances', function (Blueprint $table) {
            $table->dropColumn('horaire');
        });
    }
}

    public function down(): void
    {
        Schema::table('seances', function (Blueprint $table) {
            $table->string('horaire');
        });
    }
};