<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WorkshopController;
use App\Models\Workshop;
use App\Http\Middleware\IsAdmin;

// RUTE LANDING PAGE (Beranda untuk pengguna yang belum login)
Route::get('/', function () {
    // Kita ambil semua data bengkel untuk dipamerkan di halaman depan,
    // tapi TIDAK menghitung jarak (karena belum melacak GPS tamu).
    $workshops = App\Models\Workshop::whereNotNull('nama_bengkel')
                            ->whereNotNull('latitude')
                            ->whereNotNull('longitude')
                            ->where('status', 'disetujui') // <--- TAMBAHKAN BARIS INI
                            ->get();

    return view('welcome', compact('workshops'));
});

// 1. RUTE DASHBOARD UTAMA (Menampilkan semua bengkel terdekat)
Route::get('/dashboard', function () {
    $user = auth()->user();

    // Jika yang login ADMIN nyasar ke /dashboard biasa
    if ($user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }

    // Jika yang login OWNER
    if ($user->role === 'owner') {
        $workshop = $user->workshop; 
        return view('dashboard-owner', compact('workshop'));
    }
    
    // Jika yang login CUSTOMER
    if ($user->role === 'customer') {
        $userLat = request('lat');
        $userLng = request('lng');

        // Ambil semua data bengkel
        $workshops = Workshop::whereNotNull('nama_bengkel')
                            ->whereNotNull('latitude')
                            ->whereNotNull('longitude')
                            ->where('status', 'disetujui') // <--- TAMBAHKAN BARIS INI
                            ->get(); 

        // Hitung Jarak & Urutkan (Terdekat)
        if ($userLat && $userLng) {
            $workshops = $workshops->map(function ($bengkel) use ($userLat, $userLng) {
                $lat1 = deg2rad($userLat);
                $lon1 = deg2rad($userLng);
                $lat2 = deg2rad($bengkel->latitude);
                $lon2 = deg2rad($bengkel->longitude);

                $dLat = $lat2 - $lat1;
                $dLon = $lon2 - $lon1;

                $a = sin($dLat/2) * sin($dLat/2) + cos($lat1) * cos($lat2) * sin($dLon/2) * sin($dLon/2);
                $c = 2 * asin(sqrt($a));
                $earthRadius = 6371; // Jari-jari bumi dalam Kilometer

                $bengkel->jarak = $earthRadius * $c; 
                return $bengkel;
            });

            // Urutkan bengkel dari nilai 'jarak' yang paling kecil (terdekat)
            $workshops = $workshops->sortBy('jarak')->take(3);
        }

        return view('dashboard-customer', compact('workshops'));
    }

})->middleware(['auth', 'verified'])->name('dashboard');


// 2. RUTE BARU: HALAMAN PENCARIAN BENGKEL BERDASARKAN LAYANAN & KATA KUNCI
Route::get('/cari-bengkel', function () {
    $user = auth()->user();
    
    if ($user->role === 'customer') {
        $userLat = request('lat');
        $userLng = request('lng');
        $layanan = request('layanan'); // Menangkap klik tombol layanan dari Customer
        $keyword = request('keyword'); // Menangkap ketikan dari kotak pencarian

        $query = Workshop::whereNotNull('nama_bengkel')
                            ->whereNotNull('latitude')
                            ->whereNotNull('longitude')
                            ->where('status', 'disetujui'); // <--- TAMBAHKAN BARIS INI (Jangan lupa titik koma);

        // Tentukan judul halaman dan saring data sesuai pilihan tombol atau ketikan pencarian
        if ($layanan == 'ban_bocor') {
            $query->where('bisa_tambal_ban', true);
            $judul_halaman = "Layanan Tambal Ban Terdekat";
        } elseif ($layanan == 'perbaikan_mesin') {
            $query->where('bisa_perbaikan_mesin', true);
            $judul_halaman = "Layanan Motor Mogok Terdekat";
        } elseif (!empty($keyword)) {
            // Ubah ketikan menjadi huruf kecil semua agar lebih mudah dicek
            $keywordLower = strtolower($keyword);

            $query->where(function($q) use ($keyword, $keywordLower) {
                // 1. Cari berdasarkan Nama Bengkel atau Alamat Kota
                $q->where('nama_bengkel', 'LIKE', "%{$keyword}%")
                  ->orWhere('alamat_bengkel', 'LIKE', "%{$keyword}%");

                // 2. LOGIKA PINTAR: Jika yang diketik mengandung kata layanan, tampilkan juga!
                if (str_contains($keywordLower, 'ban') || str_contains($keywordLower, 'bocor') || str_contains($keywordLower, 'tambal')) {
                    $q->orWhere('bisa_tambal_ban', true);
                }
                
                if (str_contains($keywordLower, 'mesin') || str_contains($keywordLower, 'mogok')) {
                    $q->orWhere('bisa_perbaikan_mesin', true);
                }
            });
            
            $judul_halaman = 'Hasil Pencarian: "' . $keyword . '"';
        } else {
            $judul_halaman = "Semua Bengkel Terdekat";
        }

        $workshops = $query->get(); 

        // Hitung jarak seperti di dashboard
        if ($userLat && $userLng) {
            $workshops = $workshops->map(function ($bengkel) use ($userLat, $userLng) {
                $lat1 = deg2rad($userLat);
                $lon1 = deg2rad($userLng);
                $lat2 = deg2rad($bengkel->latitude);
                $lon2 = deg2rad($bengkel->longitude);

                $dLat = $lat2 - $lat1;
                $dLon = $lon2 - $lon1;

                $a = sin($dLat/2) * sin($dLat/2) + cos($lat1) * cos($lat2) * sin($dLon/2) * sin($dLon/2);
                $c = 2 * asin(sqrt($a));
                $bengkel->jarak = 6371 * $c; 
                return $bengkel;
            });

            $workshops = $workshops->sortBy('jarak');
        }

        // Arahkan ke file blade baru: cari-bengkel.blade.php
        return view('cari-bengkel', compact('workshops', 'judul_halaman'));
    }
    return redirect('/dashboard');
})->middleware(['auth', 'verified'])->name('cari.bengkel');


// 3. RUTE KHUSUS OWNER (Tidak ada yang diubah, tetap sama)
Route::get('/owner/layanan', function () {
    $user = auth()->user();
    if ($user->role === 'owner') {
        $workshop = $user->workshop;
        return view('layanan-owner', compact('workshop'));
    }
    return redirect('/dashboard');
})->middleware(['auth', 'verified'])->name('owner.layanan');

Route::get('/owner/pembayaran', function () {
    $user = auth()->user();
    if ($user->role === 'owner') {
        $workshop = $user->workshop;
        return view('pembayaran-owner', compact('workshop'));
    }
    return redirect('/dashboard');
})->middleware(['auth', 'verified'])->name('owner.pembayaran');

Route::post('/owner/pembayaran/simpan', [WorkshopController::class, 'updatePembayaran'])
    ->middleware(['auth', 'verified'])
    ->name('owner.pembayaran.update');

Route::post('/owner/layanan/simpan', [WorkshopController::class, 'updateLayanan'])
    ->middleware(['auth', 'verified'])
    ->name('owner.layanan.update');

Route::get('/workshop/profil', [WorkshopController::class, 'show'])
    ->middleware(['auth'])
    ->name('workshop.show'); 

Route::get('/workshop/edit', [WorkshopController::class, 'edit'])
    ->middleware(['auth'])
    ->name('workshop.edit'); 

Route::post('/workshop/simpan', [WorkshopController::class, 'store'])
    ->middleware(['auth'])
    ->name('workshop.store');

Route::middleware('auth')->group(function () {
    Route::get('/profile/show', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', IsAdmin::class])->group(function () {
    
    // Halaman Dashboard Utama Admin
    Route::get('/admin/dashboard', function () {
        
        // 1. Ambil data bengkel yang statusnya 'pending' beserta data pemiliknya
        $bengkel_pending = App\Models\Workshop::with('user')
                                ->where('status', 'pending')
                                ->latest() // Urutkan dari yang terbaru
                                ->get();
                                
        // 2. Hitung statistik untuk kartu-kartu di atas tabel
        $total_customer = App\Models\User::where('role', 'customer')->count();
        $bengkel_aktif = App\Models\Workshop::where('status', 'disetujui')->count(); // Nanti kita buat status 'disetujui'
        $total_pending = $bengkel_pending->count();

        // 3. Kirim datanya ke halaman HTML (View)
        return view('admin.dashboard', compact('bengkel_pending', 'total_customer', 'bengkel_aktif', 'total_pending')); 

    })->name('admin.dashboard');

    // Halaman Khusus Antrean Verifikasi Bengkel
    Route::get('/admin/verifikasi', function () {
        $bengkel_pending = App\Models\Workshop::with('user')
                                ->where('status', 'pending')
                                ->latest()
                                ->get();
                                
        return view('admin.verifikasi', compact('bengkel_pending'));
    })->name('admin.verifikasi');

    // Rute untuk MENYETUJUI bengkel
    Route::post('/admin/bengkel/{id}/setujui', function ($id) {
        $bengkel = App\Models\Workshop::findOrFail($id);
        $bengkel->update(['status' => 'disetujui']); // Ubah status jadi disetujui
        
        return back(); // Kembalikan ke halaman sebelumnya
    })->name('admin.bengkel.setujui');

    // Rute untuk MENOLAK bengkel
    Route::post('/admin/bengkel/{id}/tolak', function ($id) {
        $bengkel = App\Models\Workshop::findOrFail($id);
        $bengkel->update(['status' => 'ditolak']); // Ubah status jadi ditolak
        
        return back(); // Kembalikan ke halaman sebelumnya
    })->name('admin.bengkel.tolak');

    // --- RUTE KELOLA PENGGUNA ---
    
    /// --- RUTE KELOLA PENGGUNA (DIPISAH) ---
    
    // 1A. Halaman Khusus Kelola Owner
    Route::get('/admin/pengguna/owner', function () {
        // 1. Hitung statistik global untuk kartu data di atas tabel
        $total_owners = App\Models\User::where('role', 'owner')->count();
        $aktif_owners = App\Models\User::where('role', 'owner')->where('status_akun', 'aktif')->count();
        $blokir_owners = App\Models\User::where('role', 'owner')->where('status_akun', 'diblokir')->count();

        // 2. Mulai membuat kerangka pencarian tabel
        $query = App\Models\User::with('workshop')
                                ->where('role', 'owner')
                                ->orderBy('created_at', 'desc');

        // Jika Admin mengetikkan sesuatu di kotak pencarian
        if (request()->has('search') && request('search') != '') {
            $search = request('search');
            $query->where(function($q) use ($search) {
                // Cari berdasarkan Nama Owner ATAU Email Owner
                $q->where('name', 'LIKE', '%' . $search . '%')
                  ->orWhere('email', 'LIKE', '%' . $search . '%')
                  // ATAU Cari berdasarkan Nama Bengkel (Relasi)
                  ->orWhereHas('workshop', function($w) use ($search) {
                      $w->where('nama_bengkel', 'LIKE', '%' . $search . '%');
                  });
            });
        }
                                
        // withQueryString() memastikan saat pindah halaman, kata pencariannya tidak hilang
        $owners = $query->paginate(5)->withQueryString(); 
                                
        // 3. Kirim data tabel & data kartu statistik ke tampilan
        return view('admin.owners', compact('owners', 'total_owners', 'aktif_owners', 'blokir_owners'));
    })->name('admin.pengguna.owner');

    // Rute untuk MENYIMPAN HASIL EDIT OWNER BENGKEL
    Route::post('/admin/pengguna/owner/{id}/update', function (Illuminate\Http\Request $request, $id) {
        $user = App\Models\User::findOrFail($id);
        
        // 1. Update data pribadi Owner (Tanpa Foto)
        $user->name = $request->name;
        $user->email = $request->email;
        // Kita menghapus $user->phone di sini karena disimpannya di tabel workshop
        $user->save();

        // 2. Update data Bengkelnya
        if ($user->workshop) {
            
            // ---> INI BARIS BARU YANG DITAMBAHKAN AGAR NAMA SINKRON <---
            $user->workshop->nama_kepala_bengkel = $request->name; 
            
            $user->workshop->nama_bengkel = $request->nama_bengkel;
            $user->workshop->alamat_bengkel = $request->alamat_bengkel;
            $user->workshop->latitude = $request->latitude;
            $user->workshop->longitude = $request->longitude;
            $user->workshop->nomor_kontak = $request->nomor_kontak; // <--- INI TAMBAHANNYA

            // Logika untuk menyimpan FOTO BENGKEL baru
            if ($request->hasFile('foto_bengkel')) {
                $file_bengkel = $request->file('foto_bengkel');
                $nama_file_bengkel = time() . "_bengkel_" . $file_bengkel->getClientOriginalName();
                $file_bengkel->move(public_path('uploads/bengkel'), $nama_file_bengkel);
                $user->workshop->foto_bengkel = 'uploads/bengkel/' . $nama_file_bengkel;
            }

            $user->workshop->save();
        }

        return back();
    })->name('admin.pengguna.owner.update');

    // 1B. Halaman Khusus Kelola Customer
    Route::get('/admin/pengguna/customer', function () {
        // 1. Hitung statistik global untuk kartu data di atas tabel
        $total_customers = App\Models\User::where('role', 'customer')->count();
        $aktif_customers = App\Models\User::where('role', 'customer')->where('status_akun', 'aktif')->count();
        $blokir_customers = App\Models\User::where('role', 'customer')->where('status_akun', 'diblokir')->count();

        // 2. Mulai membuat kerangka pencarian tabel
        $query = App\Models\User::where('role', 'customer')
                                ->orderBy('created_at', 'desc');

        // Jika Admin mengetikkan sesuatu di kotak pencarian
        if (request()->has('search') && request('search') != '') {
            $search = request('search');
            $query->where(function($q) use ($search) {
                // Cari berdasarkan Nama ATAU Email
                $q->where('name', 'LIKE', '%' . $search . '%')
                  ->orWhere('email', 'LIKE', '%' . $search . '%');
            });
        }
                                
        // withQueryString() memastikan saat pindah halaman, kata pencariannya tidak hilang
        $customers = $query->paginate(5)->withQueryString(); 
                                
        // 3. Kirim data tabel & data kartu statistik ke tampilan (View)
        return view('admin.customers', compact('customers', 'total_customers', 'aktif_customers', 'blokir_customers'));
    })->name('admin.pengguna.customer');

    // Rute untuk MENYIMPAN HASIL EDIT CUSTOMER
    Route::post('/admin/pengguna/customer/{id}/update', function (Illuminate\Http\Request $request, $id) {
        $user = App\Models\User::findOrFail($id);
        
        // Update data teks
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone; // <-- Menggunakan 'phone'

        // Update foto jika Admin mengunggah foto baru
        if ($request->hasFile('photo')) { // <-- Menggunakan 'photo'
            $file = $request->file('photo'); // <-- Menggunakan 'photo'
            $nama_file = time() . "_" . $file->getClientOriginalName();
            $file->move(public_path('uploads/profil'), $nama_file);
            $user->photo = 'uploads/profil/' . $nama_file; // <-- Menggunakan 'photo'
        }

        $user->save();
        return back();
    })->name('admin.pengguna.customer.update');
    
    // (Catatan: Rute Tombol Aksi Blokir biarkan saja tetap sama)

    // 2. Tombol Aksi untuk Blokir / Buka Blokir
    Route::post('/admin/pengguna/{id}/toggle-blokir', function ($id) {
        $user = App\Models\User::findOrFail($id);
        
        // Jika statusnya aktif, maka ubah jadi blokir. Jika blokir, kembalikan jadi aktif.
        if ($user->status_akun === 'aktif') {
            $user->update(['status_akun' => 'diblokir']);
        } else {
            $user->update(['status_akun' => 'aktif']);
        }
        
        return back();
    })->name('admin.pengguna.toggle');

});

require __DIR__.'/auth.php';