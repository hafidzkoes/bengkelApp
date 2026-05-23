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
                    
                    <div class="relative">
                        <input id="password" type="password" name="password" required autocomplete="current-password"
                            class="block w-full border-gray-300 focus:border-red-500 focus:ring-red-500 rounded-lg shadow-sm sm:text-sm px-4 py-2.5 pr-10 transition">
                        
                        <button type="button" onclick="toggleVisibility('password', 'icon-pass')" 
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500 hover:text-red-600 focus:outline-none transition">
                            <svg id="icon-pass" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>

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

    <script>
        function toggleVisibility(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />';
            } else {
                input.type = 'password';
                icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />';
            }
        }
    </script>
</body>
</html>