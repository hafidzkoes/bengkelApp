<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // public function up(): void
    // {
    //     Schema::create('workshops', function (Blueprint $table) {
    //         $table->id();
    //         $table->timestamps();
    //     });
    // }

       public function up(): void
       {
           Schema::create('workshops', function (Blueprint $table) {
               $table->id();
        
        // Relasi ke tabel users. 'cascade' artinya jika akun user dihapus, profil bengkel otomatis terhapus
               $table->foreignId('user_id')->constrained()->onDelete('cascade'); 
        
        // Kolom data bengkel
               $table->string('nama_bengkel');
               $table->string('foto_bengkel')->nullable(); // nullable = boleh kosong (nanti diisi nama file gambar)
               $table->text('alamat_bengkel'); // text digunakan agar bisa menampung alamat panjang
               $table->string('nomor_kontak');
               $table->string('nama_kepala_bengkel')->nullable(); // nullable = opsional, tidak wajib diisi

               // 1. Tambahan untuk Status Operasional & Layanan
               $table->boolean('status_operasional')->default(true); // true = Buka/Tersedia
               $table->boolean('bisa_tambal_ban')->default(false);
               $table->boolean('bisa_perbaikan_mesin')->default(false);
        
               $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workshops');
    }
};
