<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workshop extends Model
{
    use HasFactory;

    // 1. Mengizinkan kolom ini diisi oleh user
    protected $fillable = [
        'user_id',
        'nama_bengkel',
        'foto_bengkel',
        'alamat_bengkel',
        'nomor_kontak',
        'nama_kepala_bengkel',
        // Tambahkan 3 baris ini:
        'status_operasional',
        'bisa_tambal_ban',
        'bisa_perbaikan_mesin',
        'jam_buka', // <-- Tambahkan ini
        'jam_tutup', // <-- Tambahkan ini
        'harga_tambal_ban',      // <-- Tambahkan ini
        'harga_perbaikan_mesin',  // <-- Tambahkan ini
        'tampilkan_harga_ban',    // <-- Tambahkan ini
        'tampilkan_harga_mesin',  // <-- Tambahkan ini
        'latitude',   // <-- Tambahkan ini
        'longitude',  // <-- Tambahkan ini
    ];

    // 2. Mendefinisikan relasi ke model User (Kebalikan)
    // Artinya: "Profil bengkel ini adalah milik satu User"
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}