<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kelola Owner - Admin BengkelApp</title>
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
            
            <a href="{{ route('admin.verifikasi') }}" class="flex items-center justify-between px-3 py-2.5 text-gray-600 hover:bg-gray-50 hover:text-indigo-600 rounded-lg font-semibold transition">
                <span>Verifikasi Bengkel</span>
                @php $pending_count = App\Models\Workshop::where('status', 'pending')->count(); @endphp
                @if($pending_count > 0)
                    <span class="bg-red-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full">{{ $pending_count }}</span>
                @endif
            </a>
            
            <a href="{{ route('admin.pengguna.owner') }}" class="block px-3 py-2.5 bg-indigo-50 text-indigo-700 rounded-lg font-bold transition">
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
            <h2 class="font-bold text-gray-800">Manajemen Owner Bengkel</h2>
        </header>

        <main class="flex-1 overflow-y-auto bg-gray-50 p-6 md:p-8">
            <div class="max-w-6xl mx-auto">
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 transition hover:shadow-md">
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Total Bengkel</p>
                        <h3 class="text-2xl font-extrabold text-gray-900">{{ $total_owners }}</h3>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 transition hover:shadow-md">
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Akun Aktif</p>
                        <h3 class="text-2xl font-extrabold text-gray-900">{{ $aktif_owners }}</h3>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 transition hover:shadow-md">
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Akun Diblokir</p>
                        <h3 class="text-2xl font-extrabold text-gray-900">{{ $blokir_owners }}</h3>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                    
                    <div class="px-6 py-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <h3 class="font-bold text-gray-900 text-lg">
                            Daftar Pemilik Bengkel
                        </h3>
                        
                        <form action="{{ route('admin.pengguna.owner') }}" method="GET" class="flex items-center gap-2">
                            <div class="relative text-gray-400 focus-within:text-indigo-500">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg class="w-4 h-4 transition-colors" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                                    </svg>
                                </div>
                                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, email, atau bengkel..." class="pl-9 pr-4 py-2 w-full sm:w-72 rounded-lg border border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-100 text-sm font-medium transition outline-none">
                            </div>

                            <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-sm rounded-lg shadow-sm transition">Cari</button>
                            
                            @if(request('search'))
                                <a href="{{ route('admin.pengguna.owner') }}" class="px-3 py-2 bg-gray-100 hover:bg-red-50 text-gray-500 hover:text-red-600 font-bold text-sm rounded-lg shadow-sm transition" title="Hapus Pencarian">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                    </svg>
                                </a>
                            @endif
                        </form>
                    </div>
                    
                    <div class="overflow-x-auto overflow-visible border-t border-gray-200">
                        <table class="w-full text-left text-sm text-gray-700">
                            <thead class="bg-gray-50/80 text-gray-600 font-semibold border-b border-gray-200">
                                <tr>
                                    <th class="px-6 py-4 w-16 whitespace-nowrap">Foto Bengkel</th>
                                    <th class="px-6 py-4 whitespace-nowrap">Nama Pemilik Bengkel</th>
                                    <th class="px-6 py-4 whitespace-nowrap">Nama Bengkel</th>
                                    <th class="px-6 py-4 whitespace-nowrap">Status Akun</th>
                                    <th class="px-6 py-4 text-center whitespace-nowrap">Aksi Kendali</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($owners as $owner)
                                <tr class="hover:bg-gray-50/50 transition">
                                    
                                    <td class="px-6 py-4">
                                        @if($owner->workshop && !empty($owner->workshop->foto_bengkel))
                                            @php
                                                if (str_starts_with($owner->workshop->foto_bengkel, 'http')) {
                                                    $url_foto_bengkel = $owner->workshop->foto_bengkel;
                                                } elseif (str_starts_with($owner->workshop->foto_bengkel, 'uploads/')) {
                                                    $url_foto_bengkel = asset($owner->workshop->foto_bengkel);
                                                } else {
                                                    $url_foto_bengkel = asset('storage/' . $owner->workshop->foto_bengkel);
                                                }
                                            @endphp
                                            <img src="{{ $url_foto_bengkel }}" class="w-12 h-12 rounded-xl object-cover border border-gray-200 shadow-sm" title="Foto Bengkel">
                                        @else
                                            <div class="w-12 h-12 rounded-xl bg-gray-200 flex items-center justify-center text-gray-500 font-bold shadow-sm">
                                                {{ substr($owner->name, 0, 1) }}
                                            </div>
                                        @endif
                                    </td>

                                    <td class="px-6 py-4">
                                        <div class="font-semibold text-gray-900">{{ optional($owner->workshop)->nama_kepala_bengkel ?? $owner->name }}</div>
                                        <div class="text-xs text-gray-500 mt-0.5">{{ $owner->email }}</div>
                                    </td>
                                    
                                    <td class="px-6 py-4">
                                        @if($owner->workshop)
                                            <div class="font-semibold text-indigo-700">{{ $owner->workshop->nama_bengkel ?? 'Belum Dinamai' }}</div>
                                            <div class="text-[10px] text-gray-500 uppercase tracking-wider mt-0.5">
                                                {{ $owner->workshop->status === 'disetujui' ? 'Tampil di Peta' : 'Pending' }}
                                            </div>
                                        @else
                                            <span class="text-xs text-gray-400 italic">Belum melengkapi bengkel</span>
                                        @endif
                                    </td>

                                    <td class="px-6 py-4">
                                        @if($owner->status_akun === 'aktif')
                                            <span class="text-green-600 font-semibold flex items-center gap-1.5"><span class="w-2 h-2 rounded-full bg-green-500 inline-block"></span> Aktif</span>
                                        @else
                                            <span class="text-red-600 font-semibold flex items-center gap-1.5"><span class="w-2 h-2 rounded-full bg-red-500 inline-block"></span> Diblokir</span>
                                        @endif
                                    </td>
                                    
                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-center gap-2">
                                            
                                            <button type="button" onclick="document.getElementById('modal-edit-owner-{{ $owner->id }}').classList.remove('hidden')" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow-sm font-semibold text-xs transition">
                                                Detail / Edit
                                            </button>

                                            <form action="{{ route('admin.pengguna.toggle', $owner->id) }}" method="POST">
                                                @csrf
                                                @if($owner->status_akun === 'aktif')
                                                    <button type="submit" onclick="return confirm('Yakin ingin memblokir Owner ini?')" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg shadow-sm font-semibold text-xs transition">Blokir</button>
                                                @else
                                                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg shadow-sm font-semibold text-xs transition">Pulihkan</button>
                                                @endif
                                            </form>
                                        </div>

                                        <div id="modal-edit-owner-{{ $owner->id }}" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 backdrop-blur-sm transition-opacity text-left">
                                            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto border border-gray-200">
                                                
                                                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex justify-between items-center sticky top-0 z-10">
                                                    <h3 class="font-bold text-gray-800 text-lg">Detail & Edit Data Bengkel</h3>
                                                    <button type="button" onclick="document.getElementById('modal-edit-owner-{{ $owner->id }}').classList.add('hidden')" class="text-gray-400 hover:text-gray-700 font-bold text-xl transition">&times;</button>
                                                </div>

                                                <form action="{{ route('admin.pengguna.owner.update', $owner->id) }}" method="POST" enctype="multipart/form-data" class="p-6 text-left">
                                                    @csrf
                                                    
                                                    <div class="bg-gray-50 border border-gray-200 rounded-xl p-5 mb-6">
                                                        <h4 class="font-semibold text-gray-800 mb-4">Informasi Pribadi Pemilik</h4>
                                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                                            <div>
                                                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Nama Pemilik Bengkel</label>
                                                                <input type="text" name="name" value="{{ optional($owner->workshop)->nama_kepala_bengkel ?? $owner->name }}" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 text-sm font-medium">
                                                            </div>
                                                            <div>
                                                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Alamat Email</label>
                                                                <input type="email" name="email" value="{{ $owner->email }}" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 text-sm font-medium">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="bg-white border border-gray-200 rounded-xl p-5">
                                                        <h4 class="font-semibold text-gray-800 mb-4">Informasi Operasional Bengkel</h4>
                                                        <div class="space-y-4">
                                                            
                                                            <div class="flex items-center gap-4 mb-4 pb-4 border-b border-gray-100">
                                                                @if($owner->workshop && !empty($owner->workshop->foto_bengkel))
                                                                    @php
                                                                        if (str_starts_with($owner->workshop->foto_bengkel, 'http')) {
                                                                            $url_bengkel = $owner->workshop->foto_bengkel;
                                                                        } elseif (str_starts_with($owner->workshop->foto_bengkel, 'uploads/')) {
                                                                            $url_bengkel = asset($owner->workshop->foto_bengkel);
                                                                        } else {
                                                                            $url_bengkel = asset('storage/' . $owner->workshop->foto_bengkel);
                                                                        }
                                                                    @endphp
                                                                    <img src="{{ $url_bengkel }}" class="w-20 h-20 rounded-xl object-cover border border-gray-200 shadow-sm">
                                                                @else
                                                                    <div class="w-20 h-20 rounded-xl bg-gray-100 flex items-center justify-center text-gray-400 font-bold border border-gray-200 shadow-sm text-xs text-center p-2">
                                                                        Belum Ada Foto
                                                                    </div>
                                                                @endif
                                                                <div class="flex-1">
                                                                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Ganti Foto Bengkel</label>
                                                                    <input type="file" name="foto_bengkel" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200 transition cursor-pointer">
                                                                </div>
                                                            </div>

                                                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                                                <div>
                                                                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Nama Bengkel</label>
                                                                    <input type="text" name="nama_bengkel" value="{{ optional($owner->workshop)->nama_bengkel }}" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 text-sm font-medium">
                                                                </div>
                                                                <div>
                                                                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Nomor WhatsApp</label>
                                                                    <input type="text" name="nomor_kontak" value="{{ $owner->workshop->nomor_kontak ?? '' }}" placeholder="Contoh: 08123456789" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 text-sm font-medium">
                                                                </div>
                                                            </div>
                                                            
                                                            <div>
                                                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Alamat Lengkap</label>
                                                                <textarea name="alamat_bengkel" rows="2" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 text-sm font-medium">{{ optional($owner->workshop)->alamat_bengkel }}</textarea>
                                                            </div>

                                                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                                                <div>
                                                                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Garis Lintang (Latitude)</label>
                                                                    <input type="text" name="latitude" value="{{ optional($owner->workshop)->latitude }}" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 text-sm font-medium">
                                                                </div>
                                                                <div>
                                                                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Garis Bujur (Longitude)</label>
                                                                    <input type="text" name="longitude" value="{{ optional($owner->workshop)->longitude }}" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 text-sm font-medium">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="mt-6 flex justify-end gap-3 sticky bottom-0 bg-white pt-4 border-t border-gray-100">
                                                        <button type="button" onclick="document.getElementById('modal-edit-owner-{{ $owner->id }}').classList.add('hidden')" class="px-4 py-2 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 font-bold text-xs rounded-lg uppercase tracking-wider transition">Batal</button>
                                                        <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs rounded-lg uppercase tracking-wider shadow-sm transition">Simpan Perubahan</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                        <svg class="w-12 h-12 mx-auto text-gray-300 mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                                        </svg>
                                        <p class="font-medium text-gray-600">Tidak ada owner/bengkel yang sesuai dengan pencarian Anda.</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                        
                        <div class="px-6 py-4 bg-white border-t border-gray-200">
                            {{ $owners->links() }}
                        </div>

                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>