<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Workshop;

class WorkshopController extends Controller
{
    // Fungsi untuk menampilkan profil bengkel
    public function show()
    {
        $user = auth()->user();
        $workshop = $user->workshop;

        return view('workshop.show', compact('user', 'workshop'));
    }

    // Fungsi untuk menampilkan form edit profil
    public function edit()
    {
        $user = auth()->user();
        $workshop = $user->workshop;
        
        return view('workshop.edit', compact('user', 'workshop'));
    }

    // Fungsi untuk menyimpan data edit profil (termasuk foto)
    public function store(Request $request)
    {
        // 1. Validasi input dari form
        $request->validate([
            'nama_bengkel' => 'required|string|max:255',
            'alamat_bengkel' => 'required|string',
            'nomor_kontak' => 'required|string|max:20',
            'nama_kepala_bengkel' => 'nullable|string|max:255',
            'foto_bengkel' => 'nullable|image|max:2048', // Maksimal ukuran 2MB
            'latitude' => 'nullable|numeric',  // <-- BARU
            'longitude' => 'nullable|numeric', // <-- BARU
        ]);

        $user = auth()->user();
        
        // 2. Siapkan data dasar yang akan disimpan
        $data = [
            'nama_bengkel' => $request->nama_bengkel,
            'alamat_bengkel' => $request->alamat_bengkel,
            'nomor_kontak' => $request->nomor_kontak,
            'nama_kepala_bengkel' => $request->nama_kepala_bengkel,
            'latitude' => $request->latitude,   // <-- BARU
            'longitude' => $request->longitude, // <-- BARU
        ];

        // 3. Logika untuk menyimpan file foto jika Owner mengunggah foto baru
        if ($request->hasFile('foto_bengkel')) {
            // Simpan file ke folder 'storage/app/public/foto_bengkel'
            $path = $request->file('foto_bengkel')->store('foto_bengkel', 'public');
            // Masukkan path foto tersebut ke dalam array data yang akan di-save ke database
            $data['foto_bengkel'] = $path;
        }

        // 4. Simpan atau Update profil di database
        $user->workshop()->updateOrCreate(
            ['user_id' => $user->id],
            $data
        );

        return redirect()->route('workshop.show')->with('success', 'Profil dan Lokasi Bengkel berhasil disimpan!');
    }

    // Fungsi untuk menyimpan pengaturan jam dan layanan darurat
    public function updateLayanan(Request $request)
    {
        $user = auth()->user();

        // Pastikan yang mengakses ini punya profil bengkel
        if ($user->workshop) {
            $user->workshop->update([
                'jam_buka' => $request->jam_buka,
                'jam_tutup' => $request->jam_tutup,
                'bisa_tambal_ban' => $request->has('bisa_tambal_ban'),
                'bisa_perbaikan_mesin' => $request->has('bisa_perbaikan_mesin'),
            ]);

            return back()->with('success', 'Pengaturan Jam & Layanan berhasil diperbarui!');
        }

        return back()->with('error', 'Silakan isi profil bengkel terlebih dahulu!');
    }
    

    public function updatePembayaran(Request $request)
    {
        $request->validate([
            'harga_tambal_ban' => 'required|numeric|min:0',
            'harga_perbaikan_mesin' => 'required|numeric|min:0',
        ]);

        $user = auth()->user();

        if ($user->workshop) {
            $user->workshop->update([
                'harga_tambal_ban' => $request->harga_tambal_ban,
                'harga_perbaikan_mesin' => $request->harga_perbaikan_mesin,
                // Menggunakan has() karena jika checkbox tidak dicentang, nilainya tidak ikut terkirim
                'tampilkan_harga_ban' => $request->has('tampilkan_harga_ban'),
                'tampilkan_harga_mesin' => $request->has('tampilkan_harga_mesin'),
            ]);

            return back()->with('success', 'Tarif dan Status Pembayaran berhasil diperbarui!');
        }

        return back()->with('error', 'Silakan isi profil bengkel terlebih dahulu!');
    }


}