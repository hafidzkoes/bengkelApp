<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Super Admin - BengkelApp</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 font-sans antialiased flex h-screen overflow-hidden">

    <aside class="w-64 bg-white border-r border-gray-200 flex flex-col h-screen flex-shrink-0 shadow-sm z-20">
        <div class="h-16 flex items-center px-6 border-b border-gray-100">
            <a href="#" class="text-xl font-extrabold tracking-tight text-gray-900">
                Bengkel<span class="text-red-600">App</span>
            </a>
            <span class="ml-2 bg-red-100 text-red-600 text-[10px] font-bold px-2 py-0.5 rounded uppercase tracking-wider">Admin</span>
        </div>
        
        <nav class="flex-1 overflow-y-auto py-4 px-4 space-y-1">
            <p class="px-2 text-xs font-bold text-gray-400 uppercase tracking-wider mb-3 mt-2">Menu Kendali</p>
            
            <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2.5 bg-indigo-50 text-indigo-700 rounded-lg font-bold transition">
                Dashboard
            </a>
            
            <a href="{{ route('admin.verifikasi') }}" class="flex items-center justify-between px-3 py-2.5 text-gray-600 hover:bg-gray-50 hover:text-indigo-600 rounded-lg font-semibold transition">
                <span>Verifikasi Bengkel</span>
                @php $pending_count = App\Models\Workshop::where('status', 'pending')->count(); @endphp
                @if($pending_count > 0)
                    <span class="bg-red-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full">{{ $pending_count }}</span>
                @endif
            </a>
            
            <a href="{{ route('admin.pengguna.owner') }}" class="block px-3 py-2.5 text-gray-600 hover:bg-gray-50 hover:text-indigo-600 rounded-lg font-semibold transition">
                Kelola Owner Bengkel
            </a>
            
            <a href="{{ route('admin.pengguna.customer') }}" class="block px-3 py-2.5 text-gray-600 hover:bg-gray-50 hover:text-indigo-600 rounded-lg font-semibold transition">
                Kelola Customer
            </a>
        </nav>

        <div class="p-4 border-t border-gray-200">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full text-center px-4 py-2.5 bg-gray-50 hover:bg-red-50 text-gray-600 hover:text-red-600 rounded-lg font-bold transition text-sm">
                    Keluar
                </button>
            </form>
        </div>
    </aside>

    <div class="flex-1 flex flex-col h-screen overflow-hidden relative">
        <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-6 flex-shrink-0 z-10 shadow-sm">
            <h2 class="font-bold text-gray-800">Dashboard Utama</h2>
        </header>

        <main class="flex-1 overflow-y-auto bg-gray-50 p-6 md:p-8">
            <div class="max-w-6xl mx-auto space-y-6">
                
                <div class="bg-[#100563] rounded-2xl shadow-sm p-8 text-white border border-[#100563] relative overflow-hidden">
                    <div class="relative z-10">
                        <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight">
                            Ringkasan Sistem BengkelApp
                        </h1>
                        <p class="mt-2 text-indigo-200 text-sm max-w-xl leading-relaxed">
                            Pantau aktivitas pengguna, verifikasi pendaftaran bengkel baru, dan atur layanan dari satu tempat.
                        </p>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 transition hover:shadow-md">
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Total Pengguna</p>
                        <h3 class="text-2xl font-extrabold text-gray-900">{{ $total_customer }}</h3>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 transition hover:shadow-md">
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Bengkel Aktif</p>
                        <h3 class="text-2xl font-extrabold text-gray-900">{{ $bengkel_aktif }}</h3>
                    </div>

                    <div class="bg-red-50 rounded-xl shadow-sm border border-red-200 p-4 transition hover:shadow-md">
                        <p class="text-xs font-bold text-red-500 uppercase tracking-wider mb-1">Perlu Verifikasi</p>
                        <h3 class="text-2xl font-extrabold text-red-700">{{ $total_pending }}</h3>
                    </div>

                </div>

            </div>
        </main>
    </div>
</body>
</html>