<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Pemilik Bengkel') }}
        </h2>
    </x-slot>

    @php
        date_default_timezone_set('Asia/Jakarta');
        $waktuSekarang = date('H:i');
        $buka = false;
        
        if ($workshop && $workshop->jam_buka && $workshop->jam_tutup) {
            $jamBuka = date('H:i', strtotime($workshop->jam_buka));
            $jamTutup = date('H:i', strtotime($workshop->jam_tutup));
            
            if ($waktuSekarang >= $jamBuka && $waktuSekarang <= $jamTutup) {
                $buka = true;
            }
        }
    @endphp

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            @if($workshop)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 {{ $buka ? 'border-green-500' : 'border-red-500' }}">
                    <div class="flex flex-col md:flex-row justify-between md:items-center gap-4">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900">Selamat Datang, {{ $workshop->nama_bengkel }}!</h3>
                            <p class="text-gray-500 mt-1">Pantau aktivitas dan status bengkel Anda hari ini.</p>
                        </div>
                        
                        <div class="flex items-center gap-2 px-5 py-2.5 rounded-full font-bold {{ $buka ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            <span class="w-3 h-3 rounded-full {{ $buka ? 'bg-green-500 animate-pulse' : 'bg-red-500' }}"></span>
                            {{ $buka ? 'BENGKEL BUKA' : 'BENGKEL TUTUP' }}
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-white shadow-sm sm:rounded-lg p-6 border border-gray-100">
                        <h4 class="font-bold text-gray-700 mb-4 border-b pb-2">Jam Operasional Anda</h4>
                        @if($workshop->jam_buka && $workshop->jam_tutup)
                            <div class="flex items-center gap-3 text-lg font-semibold text-gray-800">
                                <span>🕒</span> 
                                {{ date('H:i', strtotime($workshop->jam_buka)) }} WIB 
                                <span class="text-gray-400">s/d</span> 
                                {{ date('H:i', strtotime($workshop->jam_tutup)) }} WIB
                            </div>
                        @else
                            <p class="text-gray-500 italic text-sm">Belum diatur. Silakan atur di menu Layanan.</p>
                        @endif
                    </div>

                    <div class="bg-white shadow-sm sm:rounded-lg p-6 border border-gray-100">
                        <h4 class="font-bold text-gray-700 mb-4 border-b pb-2">Layanan Aktif</h4>
                        <div class="flex flex-wrap gap-2">
                            @if($workshop->bisa_tambal_ban)
                                <span class="px-3 py-1 bg-indigo-50 text-indigo-700 font-semibold rounded-lg text-sm border border-indigo-100">⭕ Tambal Ban</span>
                            @endif
                            @if($workshop->bisa_perbaikan_mesin)
                                <span class="px-3 py-1 bg-indigo-50 text-indigo-700 font-semibold rounded-lg text-sm border border-indigo-100">🏍️ Perbaikan Mesin</span>
                            @endif
                            
                            @if(!$workshop->bisa_tambal_ban && !$workshop->bisa_perbaikan_mesin)
                                <p class="text-gray-500 italic text-sm">Belum ada layanan yang dicentang.</p>
                            @endif
                        </div>
                    </div>
                </div>

                @if(($workshop->tampilkan_harga_ban ?? true) || ($workshop->tampilkan_harga_mesin ?? true))
                    <div class="bg-white shadow-sm sm:rounded-lg p-6 border border-gray-100">
                        <h4 class="font-bold text-gray-700 mb-4 border-b pb-2">Status Pembayaran & Estimasi Tarif</h4>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            
                            @if($workshop->tampilkan_harga_ban ?? true)
                                <div class="p-4 bg-green-50/50 rounded-xl border border-green-100 flex justify-between items-center">
                                    <div>
                                        <span class="text-xs text-gray-500 font-bold uppercase">Estimasi Jasa Ban Bocor</span>
                                        <p class="text-xl font-extrabold text-green-700 mt-1">Rp {{ number_format($workshop->harga_tambal_ban ?? 0, 0, ',', '.') }}</p>
                                    </div>
                                    <span class="text-2xl">💵</span>
                                </div>
                            @endif

                            @if($workshop->tampilkan_harga_mesin ?? true)
                                <div class="p-4 bg-blue-50/50 rounded-xl border border-blue-100 flex justify-between items-center">
                                    <div>
                                        <span class="text-xs text-gray-500 font-bold uppercase">Estimasi Jasa Motor Mogok</span>
                                        <p class="text-xl font-extrabold text-blue-700 mt-1">Rp {{ number_format($workshop->harga_perbaikan_mesin ?? 0, 0, ',', '.') }}</p>
                                    </div>
                                    <span class="text-2xl">💳</span>
                                </div>
                            @endif

                        </div>
                    </div>
                @endif
                
            @else
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-red-500">
                    <h3 class="text-xl font-bold text-red-600 mb-2">Profil Bengkel Belum Lengkap!</h3>
                    <p class="mb-4">Silakan lengkapi data bengkel Anda terlebih dahulu agar pelanggan bisa menemukan Anda di peta.</p>
                    <a href="{{ route('workshop.edit') }}" class="inline-block bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 transition">
                        Lengkapi Profil Sekarang
                    </a>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>