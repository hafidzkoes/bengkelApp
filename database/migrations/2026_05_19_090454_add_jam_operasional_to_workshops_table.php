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
        $table->time('jam_buka')->nullable();
        $table->time('jam_tutup')->nullable();
    });
}

public function down()
{
    Schema::table('workshops', function (Blueprint $table) {
        $table->dropColumn(['jam_buka', 'jam_tutup']);
    });
}
};
