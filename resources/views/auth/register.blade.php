<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>Daftar Akun - BengkelApp</title>
    
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
            <p class="text-gray-500 mt-2 text-sm font-medium">Silakan lengkapi data untuk membuat akun</p>
        </div>

        <div class="bg-white px-8 py-10 shadow-lg border border-gray-100 rounded-2xl">
            <form method="POST" action="{{ route('register') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="name" class="block font-semibold text-sm text-gray-700 mb-1">Nama Lengkap</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                        class="block w-full border-gray-300 focus:border-red-500 focus:ring-red-500 rounded-lg shadow-sm sm:text-sm px-4 py-2.5 transition">
                    @error('name')
                        <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block font-semibold text-sm text-gray-700 mb-1">Alamat Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required
                        class="block w-full border-gray-300 focus:border-red-500 focus:ring-red-500 rounded-lg shadow-sm sm:text-sm px-4 py-2.5 transition">
                    @error('email')
                        <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="role" class="block font-semibold text-sm text-gray-700 mb-1">Daftar Sebagai</label>
                    <select id="role" name="role" required
                        class="block w-full border-gray-300 focus:border-red-500 focus:ring-red-500 rounded-lg shadow-sm sm:text-sm px-4 py-2.5 transition bg-white cursor-pointer">
                        <option value="customer" {{ old('role') == 'customer' ? 'selected' : '' }}>Customer (Pencari Bengkel)</option>
                        <option value="owner" {{ old('role') == 'owner' ? 'selected' : '' }}>Pemilik Bengkel</option>
                    </select>
                    @error('role')
                        <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block font-semibold text-sm text-gray-700 mb-1">Password</label>
                    <input id="password" type="password" name="password" required
                        class="block w-full border-gray-300 focus:border-red-500 focus:ring-red-500 rounded-lg shadow-sm sm:text-sm px-4 py-2.5 transition">
                    @error('password')
                        <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block font-semibold text-sm text-gray-700 mb-1">Konfirmasi Password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required
                        class="block w-full border-gray-300 focus:border-red-500 focus:ring-red-500 rounded-lg shadow-sm sm:text-sm px-4 py-2.5 transition">
                </div>

                <div class="pt-4 mt-6 border-t border-gray-100">
                    <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-bold text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors tracking-wide">
                        DAFTAR SEKARANG
                    </button>
                    
                    <div class="text-center mt-5">
                        <span class="text-sm text-gray-500">Sudah punya akun?</span>
                        <a href="{{ route('login') }}" class="text-sm font-bold text-red-600 hover:text-red-700 hover:underline transition ml-1">
                            Masuk di sini
                        </a>
                    </div>
                </div>

            </form>
        </div>
        
    </div>
</body>
</html>