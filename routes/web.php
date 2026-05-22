<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WorkshopController;
use App\Models\Workshop;

Route::get('/', function () {
    return view('welcome');
});

// 1. RUTE DASHBOARD UTAMA (Menampilkan semua bengkel terdekat)
Route::get('/dashboard', function () {
    $user = auth()->user();

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
            $workshops = $workshops->sortBy('jarak');
        }

        return view('dashboard-customer', compact('workshops'));
    }

})->middleware(['auth', 'verified'])->name('dashboard');


// 2. RUTE BARU: HALAMAN PENCARIAN BENGKEL BERDASARKAN LAYANAN (Halaman Baru)
Route::get('/cari-bengkel', function () {
    $user = auth()->user();
    
    if ($user->role === 'customer') {
        $userLat = request('lat');
        $userLng = request('lng');
        $layanan = request('layanan'); // Menangkap klik tombol dari Customer

        $query = Workshop::whereNotNull('nama_bengkel')
                            ->whereNotNull('latitude')
                            ->whereNotNull('longitude');

        // Tentukan judul halaman dan saring data sesuai pilihan tombol
        if ($layanan == 'ban_bocor') {
            $query->where('bisa_tambal_ban', true);
            $judul_halaman = "Layanan Tambal Ban Terdekat";
        } elseif ($layanan == 'perbaikan_mesin') {
            $query->where('bisa_perbaikan_mesin', true);
            $judul_halaman = "Layanan Motor Mogok Terdekat";
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

require __DIR__.'/auth.php';