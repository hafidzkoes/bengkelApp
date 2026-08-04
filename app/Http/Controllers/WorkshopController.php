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
        $request->validate([
            'nama_bengkel' => 'required|string|max:255',
            'alamat_bengkel' => 'required|string',
            'nomor_kontak' => 'required|string|max:20',
            'nama_kepala_bengkel' => 'nullable|string|max:255',
            'foto_bengkel' => 'nullable|image|max:20480', 
            'latitude' => 'nullable|numeric',  
            'longitude' => 'nullable|numeric', 
            'jam_buka' => 'nullable|date_format:H:i',  
            'jam_tutup' => 'nullable|date_format:H:i', 
        ]);

        $user = auth()->user();
        
        $data = [
            'nama_bengkel' => $request->nama_bengkel,
            'alamat_bengkel' => $request->alamat_bengkel,
            'nomor_kontak' => $request->nomor_kontak,
            'nama_kepala_bengkel' => $request->nama_kepala_bengkel,
            'latitude' => $request->latitude,   
            'longitude' => $request->longitude, 
            'jam_buka' => $request->jam_buka,   
            'jam_tutup' => $request->jam_tutup, 
        ];

        if ($request->hasFile('foto_bengkel')) {
            $path = $request->file('foto_bengkel')->store('foto_bengkel', 'public');
            $data['foto_bengkel'] = $path;
        }

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
    
    // FUNGSI INI DIUBAH: Menggunakan Validasi Kondisional (Pintar)
    public function updatePembayaran(Request $request)
    {
        // 1. Buat wadah aturan validasi kosong
        $rules = [];

        // 2. HANYA periksa keamanan Nominal JIKA kotaknya DICENTANG
        if ($request->has('tampilkan_harga_ban')) {
            $rules['harga_tambal_ban'] = 'required|numeric|min:0|max:100000000';
        }
        
        if ($request->has('tampilkan_harga_mesin')) {
            $rules['harga_perbaikan_mesin'] = 'required|numeric|min:0|max:100000000';
        }

        // 3. Jalankan pengecekan keamanan
        $request->validate($rules, [
            'harga_tambal_ban.required' => 'Nominal tarif jasa ban bocor wajib diisi!',
            'harga_perbaikan_mesin.required' => 'Nominal tarif jasa motor mogok wajib diisi!',
            'harga_tambal_ban.max' => 'Nominal tersebut tidak logis untuk tarif jasa ban bocor!',
            'harga_perbaikan_mesin.max' => 'Nominal tersebut tidak logis untuk tarif jasa motor mogok!',
            'harga_tambal_ban.min' => 'Nominal tarif tidak boleh negatif!',
            'harga_perbaikan_mesin.min' => 'Nominal tarif tidak boleh negatif!',
            'harga_tambal_ban.numeric' => 'Tarif harus berupa angka!',
            'harga_perbaikan_mesin.numeric' => 'Tarif harus berupa angka!',
        ]);

        $user = auth()->user();

        if ($user->workshop) {
            // 4. Update status sakelarnya saja terlebih dahulu (Nyala/Mati)
            $updateData = [
                'tampilkan_harga_ban' => $request->has('tampilkan_harga_ban'),
                'tampilkan_harga_mesin' => $request->has('tampilkan_harga_mesin'),
            ];

            // 5. HANYA simpan nominal harga baru JIKA kotaknya dicentang.
            // (Jika centang dilepas, sistem membiarkan harga lama tetap aman di Database)
            if ($request->has('tampilkan_harga_ban')) {
                $updateData['harga_tambal_ban'] = $request->harga_tambal_ban;
            }
            if ($request->has('tampilkan_harga_mesin')) {
                $updateData['harga_perbaikan_mesin'] = $request->harga_perbaikan_mesin;
            }

            // 6. Eksekusi penyimpanan ke Database
            $user->workshop->update($updateData);

            return back()->with('success', 'Tarif dan Status Pembayaran berhasil diperbarui!');
        }

        return back()->with('error', 'Silakan isi profil bengkel terlebih dahulu!');
    }
}