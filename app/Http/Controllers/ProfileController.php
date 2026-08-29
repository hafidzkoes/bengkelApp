<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Validation\Rule; // <-- Ditambahkan untuk mengecek duplikat email

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function show(Request $request)
    {
        return view('profile.show', [
            'user' => $request->user(),
        ]);
    }

    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();

        // -------------------------------------------------------------
        // 1. SATPAM LAPIS 2 (ATURAN VALIDASI & PESAN ERROR MERAH)
        // -------------------------------------------------------------
        $aturan = [
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
        ];

        $pesan_error = [
            'name.required' => 'Nama Lengkap tidak boleh dikosongkan!',
            'email.required' => 'Email tidak boleh dikosongkan!',
            'email.unique' => 'Email ini sudah dipakai akun lain, gunakan email berbeda!',
        ];

        // Jika yang login adalah Customer, tambahkan aturan wajib untuk WhatsApp
        if ($user->role === 'customer') {
            $aturan['phone'] = 'required|string|max:20';
            $pesan_error['phone.required'] = 'Nomor WhatsApp tidak boleh dikosongkan!';
            
            // Aturan opsional untuk foto (jika diisi, harus berupa gambar)
            $aturan['photo'] = 'nullable|image|mimes:jpeg,png,jpg|max:2048';
            $pesan_error['photo.image'] = 'File yang diunggah harus berupa foto (JPEG/PNG/JPG)!';
            $pesan_error['photo.max'] = 'Ukuran foto terlalu besar (Maksimal 2MB)!';
        }

        // Jalankan Satpam! (Jika ada yang kosong, proses berhenti di sini dan kembali ke halaman form)
        $request->validate($aturan, $pesan_error);


        // -------------------------------------------------------------
        // 2. SIMPAN DATA JIKA LOLOS VALIDASI
        // -------------------------------------------------------------
        $user->name = $request->name;
        $user->email = $request->email;

        if ($user->role === 'customer') {
            $user->phone = $request->phone;
        }

        // 3. Logika Upload Foto
        if ($request->hasFile('photo')) {
            // Hapus foto lama jika ada agar memori tidak penuh
            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }

            // Simpan foto baru ke folder 'profile_photos' di folder storage/app/public
            $path = $request->file('photo')->store('profile_photos', 'public');
            $user->photo = $path;
        }

        // Reset email verified jika email diganti (bawaan Laravel)
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        // -------------------------------------------------------------
        // 4. LOGIKA PENGALIHAN CERDAS BERDASARKAN ROLE
        // -------------------------------------------------------------
        if ($user->role === 'owner' || $user->role === 'admin') {
            // Jika Pemilik Bengkel/Admin, arahkan kembali ke Profil Bengkel
            return Redirect::route('workshop.show')->with('success', 'Pengaturan akun login berhasil diperbarui!');
        }

        // Jika Customer, arahkan ke halaman Profil Pengguna
        return Redirect::route('profile.show')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}