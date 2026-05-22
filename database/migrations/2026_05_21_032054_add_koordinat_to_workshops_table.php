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
        Schema::table('workshops', function (Blueprint $table) {
            // Presisi 10 dan 8 (contoh: -6.20000000) agar sangat akurat
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
        });
    }

    public function down()
    {
        Schema::table('workshops', function (Blueprint $table) {
            $table->dropColumn(['latitude', 'longitude']);
        });
    }
};
