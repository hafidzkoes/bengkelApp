<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Verifikasi Bengkel - Admin BengkelApp</title>
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
            
            <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2.5 text-gray-600 hover:bg-gray-50 hover:text-indigo-600 rounded-lg font-semibold transition">
                Dashboard
            </a>
            
            <a href="{{ route('admin.verifikasi') }}" class="flex items-center justify-between px-3 py-2.5 bg-indigo-50 text-indigo-700 rounded-lg font-bold transition">
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
            <h2 class="font-bold text-gray-800">Verifikasi Bengkel Baru</h2>
        </header>

        <main class="flex-1 overflow-y-auto bg-gray-50 p-6 md:p-8">
            <div class="max-w-6xl mx-auto space-y-8">
                
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                    
                    <div class="px-6 py-5 border-b border-gray-200 flex justify-between items-center">
                        <h3 class="font-bold text-gray-900 text-lg">
                            Daftar Antrean Verifikasi
                        </h3>
                    </div>
                    
                    <div class="overflow-x-auto overflow-visible">
                        <table class="w-full text-left text-sm text-gray-700">
                            <thead class="bg-gray-50/80 text-gray-600 font-semibold border-b border-gray-200">
                                <tr>
                                    <th class="px-6 py-4 whitespace-nowrap">Nama Bengkel</th>
                                    <th class="px-6 py-4 whitespace-nowrap">Pemilik (User)</th>
                                    <th class="px-6 py-4 whitespace-nowrap">Tanggal Daftar</th>
                                    <th class="px-6 py-4 text-center whitespace-nowrap">Aksi Kendali</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($bengkel_pending as $bengkel)
                                <tr class="hover:bg-gray-50/50 transition">
                                    <td class="px-6 py-4">
                                        <div class="font-semibold text-gray-900">{{ $bengkel->nama_bengkel }}</div>
                                        <div class="text-xs text-gray-500 mt-0.5">{{ $bengkel->alamat_bengkel }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="font-semibold text-gray-900">{{ $bengkel->user->name ?? 'Tidak Ada User' }}</div>
                                        <div class="text-xs text-gray-500 mt-0.5">{{ $bengkel->user->email ?? '-' }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-gray-500 font-medium text-xs">
                                        {{ $bengkel->created_at->format('d M Y, H:i') }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-center gap-2">
                                            
                                            <form action="{{ route('admin.bengkel.setujui', $bengkel->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg shadow-sm font-semibold text-xs transition">
                                                    Setujui
                                                </button>
                                            </form>
                                            
                                            <form action="{{ route('admin.bengkel.tolak', $bengkel->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg shadow-sm font-semibold text-xs transition" onclick="return confirm('Yakin ingin menolak bengkel ini?')">
                                                    Tolak
                                                </button>
                                            </form>

                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                                        <svg class="w-12 h-12 mx-auto text-gray-300 mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 0 1-3.296-1.043 3.745 3.745 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 0 1 1.043-3.296 3.746 3.746 0 0 1 3.296-1.043A3.746 3.746 0 0 1 12 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 0 1 3.296 1.043 3.746 3.746 0 0 1 1.043 3.296A3.745 3.745 0 0 1 21 12Z" />
                                        </svg>
                                        <p class="font-medium text-gray-600">Tidak ada antrean verifikasi bengkel saat ini.</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </main>
    </div>
</body>
</html>