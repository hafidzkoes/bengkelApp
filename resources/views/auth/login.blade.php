<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>Masuk - BengkelApp</title>
    
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50 flex items-center justify-center min-h-screen p-4">

    <div class="w-full max-w-md">
        
        <div class="text-center mb-8">
            <a href="/" class="text-4xl font-extrabold tracking-tight text-gray-900 transition hover:opacity-80">
                Bengkel<span class="text-red-600">App</span>
            </a>
            <p class="text-gray-500 mt-2 text-sm font-medium">Silakan masuk ke akun Anda</p>
        </div>

        <x-auth-session-status class="mb-4 text-center font-bold text-red-600" :status="session('status')" />

        <div class="bg-white px-8 py-10 shadow-lg border border-gray-100 rounded-2xl">
            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <div>
                    <label for="email" class="block font-semibold text-sm text-gray-700 mb-1">Alamat Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                        class="block w-full border-gray-300 focus:border-red-500 focus:ring-red-500 rounded-lg shadow-sm sm:text-sm px-4 py-2.5 transition">
                    @error('email')
                        <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <div class="flex justify-between items-center mb-1">
                        <label for="password" class="block font-semibold text-sm text-gray-700">Password</label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-xs font-semibold text-red-600 hover:text-red-700 hover:underline transition">
                                Lupa password?
                            </a>
                        @endif
                    </div>
                    <input id="password" type="password" name="password" required autocomplete="current-password"
                        class="block w-full border-gray-300 focus:border-red-500 focus:ring-red-500 rounded-lg shadow-sm sm:text-sm px-4 py-2.5 transition">
                    @error('password')
                        <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex items-center">
                    <input id="remember_me" type="checkbox" name="remember" 
                        class="rounded border-gray-300 text-red-600 shadow-sm focus:ring-red-500 cursor-pointer">
                    <label for="remember_me" class="ml-2 block text-sm text-gray-600 cursor-pointer">
                        Ingat saya di perangkat ini
                    </label>
                </div>

                <div class="pt-2 mt-6 border-t border-gray-100">
                    <button type="submit" class="w-full flex justify-center mt-4 py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-bold text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors tracking-wide">
                        MASUK
                    </button>
                    
                    <div class="text-center mt-5">
                        <span class="text-sm text-gray-500">Belum punya akun?</span>
                        <a href="{{ route('register') }}" class="text-sm font-bold text-red-600 hover:text-red-700 hover:underline transition ml-1">
                            Daftar sekarang
                        </a>
                    </div>
                </div>

            </form>
        </div>
        
    </div>
</body>
</html>