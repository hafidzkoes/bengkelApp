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
        $table->integer('harga_tambal_ban')->default(0);
        $table->integer('harga_perbaikan_mesin')->default(0);
        $table->boolean('tampilkan_harga_ban')->default(true);
        $table->boolean('tampilkan_harga_mesin')->default(true);
    });
}

public function down()
{
    Schema::table('workshops', function (Blueprint $table) {
        $table->dropColumn(['harga_tambal_ban', 'harga_perbaikan_mesin', 'tampilkan_harga_ban', 'tampilkan_harga_mesin']);
    });
}
};
