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
        Schema::table('eleves', function (Blueprint $table) {
            $table->string('father_phone')->after('phone');

            $table->dropColumn(['amount', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('eleves', function (Blueprint $table) {
            $table->dropColumn('father_phone');

            $table->decimal('amount', 8, 2)->nullable();
            $table->string('status')->nullable();
        });
    }
};
