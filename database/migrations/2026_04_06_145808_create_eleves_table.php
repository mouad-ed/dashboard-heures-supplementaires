<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('eleves', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone');
            $table->date('payment_date')->nullable();
            $table->decimal('amount', 8, 2)->default(0);
            $table->string('status'); // payé / en_attente / en_retard
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eleves');
    }
};
