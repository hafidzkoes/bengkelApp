<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // 1. Sistem mengecek kecocokan email dan password
        $request->authenticate();

        // =========================================================
        // 2. CEK STATUS BLOKIR (HAKIM KEAMANAN)
        // =========================================================
        if ($request->user()->status_akun === 'diblokir') {
            // Jika diblokir, paksa logout saat itu juga
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            // Tendang kembali ke halaman login dan berikan pesan error
            return back()->withErrors([
                'email' => 'MOHON MAAF, AKUN ANDA TELAH DIBLOKIR OLEH ADMIN KARENA MELANGGAR ATURAN BENGKELAPP.',
            ]);
        }
        // =========================================================

        // 3. Jika aman (tidak diblokir), buatkan sesi masuk
        $request->session()->regenerate();

        // 4. Cek role dari user yang baru saja berhasil login
        $role = $request->user()->role;

        if ($role === 'admin') {
            // Jika Admin, lempar ke dashboard admin
            return redirect()->route('admin.dashboard');
        } elseif ($role === 'owner') {
            // Jika Owner, lempar ke dashboard owner
            return redirect()->route('dashboard'); 
        } else {
            // Jika Customer, lempar ke halaman cari bengkel / beranda
            return redirect()->route('dashboard'); 
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}