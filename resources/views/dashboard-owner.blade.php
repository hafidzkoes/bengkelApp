<x-app-layout>
    <div class="bg-gray-50 min-h-screen text-gray-800 font-sans antialiased py-8">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            
            <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h1 class="text-xl sm:text-2xl font-extrabold text-gray-900 tracking-tight">
                        Selamat Datang, {{ Auth::user()->name }}!
                    </h1>
                    <p class="text-xs sm:text-sm text-gray-500 mt-1">
                        Pantau ringkasan data operasional dan pengaturan sistem LBS bengkel Anda di bawah ini.
                    </p>
                </div>
                <span class="inline-flex self-start sm:self-center bg-red-50 text-red-600 text-[11px] px-3 py-1 rounded-full font-bold uppercase tracking-wider border border-red-100 shadow-sm">
                    Akun Pemilik
                </span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
                
                <div class="bg-white border border-gray-200 rounded-2xl p-5 shadow-sm flex flex-col justify-between">
                    <div>
                        <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">Jam Operasional</p>
                        @if(isset($workshop->jam_buka) && isset($workshop->jam_tutup))
                            <h3 class="text-base font-bold text-gray-800 mt-2">
                                {{ \Carbon\Carbon::parse($workshop->jam_buka)->format('H:i') }} - {{ \Carbon\Carbon::parse($workshop->jam_tutup)->format('H:i') }}
                            </h3>
                        @else
                            <h3 class="text-base font-bold text-gray-400 mt-2">Belum Ditentukan</h3>
                        @endif
                    </div>
                    <div class="mt-4 pt-2 border-t border-gray-100 flex items-center justify-between">
                        <span class="text-xs text-gray-400">Status Saat Ini</span>
                        @if(isset($workshop->jam_buka) && isset($workshop->jam_tutup))
                            @php
                                $sekarang = \Carbon\Carbon::now('Asia/Jakarta')->format('H:i');
                                $jamBuka = \Carbon\Carbon::parse($workshop->jam_buka)->format('H:i');
                                $jamTutup = \Carbon\Carbon::parse($workshop->jam_tutup)->format('H:i');
                                $isBuka = ($sekarang >= $jamBuka && $sekarang <= $jamTutup);
                            @endphp
                            <span class="px-2 py-0.5 text-[10px] font-extrabold rounded-md {{ $isBuka ? 'bg-green-50 text-green-700 border border-green-200' : 'bg-gray-50 text-gray-600 border border-gray-200' }}">
                                {{ $isBuka ? 'BUKA' : 'TUTUP' }}
                            </span>
                        @else
                            <span class="text-[10px] text-gray-400 font-semibold">-</span>
                        @endif
                    </div>
                </div>

                <div class="bg-white border border-gray-200 rounded-2xl p-5 shadow-sm flex flex-col justify-between">
                    <div>
                        <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">Fitur Layanan Jasa</p>
                        <div class="mt-2.5 space-y-1.5">
                            @if(!empty($workshop->bisa_tambal_ban))
                                <div class="flex items-center">
                                    <span class="text-sm font-bold text-gray-800">Tambal / Ganti Ban</span>
                                </div>
                            @endif
                            
                            @if(!empty($workshop->bisa_perbaikan_mesin))
                                <div class="flex items-center">
                                    <span class="text-sm font-bold text-gray-800">Perbaikan Motor Mogok</span>
                                </div>
                            @endif

                            @if(empty($workshop->bisa_tambal_ban) && empty($workshop->bisa_perbaikan_mesin))
                                <span class="text-sm font-bold text-gray-400">Belum ada layanan aktif</span>
                            @endif
                        </div>
                    </div>
                    <div class="mt-4 pt-2 border-t border-gray-100 flex items-center justify-between">
                        <span class="text-xs text-gray-400">Filter Peta</span>
                        @if(!empty($workshop->bisa_tambal_ban) || !empty($workshop->bisa_perbaikan_mesin))
                            <span class="inline-flex items-center gap-1 text-[10px] text-blue-600 font-bold uppercase bg-blue-50 px-2 py-0.5 rounded-md border border-blue-200">
                                MUNCUL
                            </span>
                        @else
                            <span class="px-2 py-0.5 text-[10px] font-extrabold rounded-md bg-gray-50 text-gray-400 border border-gray-200">
                                TERSEMBUNYI
                            </span>
                        @endif
                    </div>
                </div>

                <div class="bg-white border border-gray-200 rounded-2xl p-5 shadow-sm flex flex-col justify-between">
                    <div>
                        <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">Tarif Jasa Darurat</p>
                        <div class="mt-2.5 space-y-2">
                            <div>
                                <span class="block text-[11px] text-gray-400 font-medium">Jasa Ban Bocor:</span>
                                <span class="text-sm font-extrabold text-gray-800">
                                    @if($workshop->tampilkan_harga_ban ?? true)
                                        Rp {{ number_format($workshop->harga_tambal_ban ?? 0, 0, ',', '.') }}
                                    @else
                                        <span class="text-xs text-gray-400 italic font-normal">Disembunyikan</span>
                                    @endif
                                </span>
                            </div>
                            <div>
                                <span class="block text-[11px] text-gray-400 font-medium">Jasa Motor Mogok:</span>
                                <span class="text-sm font-extrabold text-gray-800">
                                    @if($workshop->tampilkan_harga_mesin ?? true)
                                        Rp {{ number_format($workshop->harga_perbaikan_mesin ?? 0, 0, ',', '.') }}
                                    @else
                                        <span class="text-xs text-gray-400 italic font-normal">Disembunyikan</span>
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 pt-2 border-t border-gray-100 flex items-center justify-between">
                        <span class="text-xs text-gray-400">Status Info</span>
                        @if(($workshop->tampilkan_harga_ban ?? true) || ($workshop->tampilkan_harga_mesin ?? true))
                            <span class="inline-flex items-center gap-1 text-[10px] text-blue-600 font-bold uppercase bg-blue-50 px-2 py-0.5 rounded-md border border-blue-200">
                                TERPAMPANG
                            </span>
                        @else
                            <span class="px-2 py-0.5 text-[10px] font-extrabold rounded-md bg-gray-50 text-gray-400 border border-gray-200">
                                TERSEMBUNYI
                            </span>
                        @endif
                    </div>
                </div>

                <div class="bg-white border border-gray-200 rounded-2xl p-5 shadow-sm flex flex-col justify-between">
                    <div>
                        <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">Titik Koordinat</p>
                        @if(isset($workshop->latitude) && isset($workshop->longitude))
                            <h3 class="text-xs font-mono font-bold text-gray-700 mt-2.5 truncate">
                                {{ Str::limit($workshop->latitude, 8, '') }},<br>{{ Str::limit($workshop->longitude, 8, '') }}
                            </h3>
                        @else
                            <h3 class="text-sm font-bold text-amber-600 mt-2">Pin Belum<br>Dipasang</h3>
                        @endif
                    </div>
                    <div class="text-xs mt-4 pt-2 border-t border-gray-100 flex items-center justify-between">
                        <span class="text-gray-400">Sinyal Peta</span>
                        @if(isset($workshop->latitude) && isset($workshop->longitude))
                            <span class="inline-flex items-center gap-1 text-[10px] text-green-600 font-bold">
                                <span class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></span> Aktif
                            </span>
                        @else
                            <span class="w-1.5 h-1.5 rounded-full bg-amber-400"></span>
                        @endif
                    </div>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>