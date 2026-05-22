<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // Pastikan ini ada di paling atas file
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */

    // Tambahkan fungsi ini
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
    public function update(ProfileUpdateRequest $request): RedirectResponse
{
    $user = $request->user();
    
    // 1. Ambil semua data dari form (Nama & Email)
    $user->fill($request->validated());

    // 2. Simpan Nomor HP manual (karena belum ada di ProfileUpdateRequest bawaan)
    $user->phone = $request->phone;

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

    // Arahkan ke halaman SHOW (Lihat Profil) setelah simpan, bukan ke halaman edit lagi
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
