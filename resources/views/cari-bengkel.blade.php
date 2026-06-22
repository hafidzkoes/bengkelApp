<x-app-layout>
    <div class="flex flex-col bg-gray-50 min-h-screen">
        
        <div class="container mx-auto px-4 md:px-12 py-8">
            
            <div class="mb-6">
                <a href="{{ route('dashboard') }}?lat={{ request('lat') }}&lng={{ request('lng') }}" 
                   class="inline-flex items-center gap-2 px-6 py-2.5 bg-red-600 rounded-xl shadow-md text-sm font-bold text-white hover:bg-red-700 transition">
                    Kembali ke Dashboard
                </a>
            </div>

            <div class="mb-8">
                <h1 class="text-2xl md:text-3xl font-extrabold text-gray-900 tracking-tight">
                    {{ $judul_halaman }}
                </h1>
                <p class="text-gray-500 mt-1">Menampilkan hasil bengkel di sekitar Anda.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                
                @forelse($workshops as $workshop)
                    <div class="bg-white rounded-2xl shadow-md overflow-hidden border border-gray-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col h-full">
                        
                        <div class="h-44 w-full bg-gray-100 relative overflow-hidden flex-shrink-0">
                            @if($workshop->foto_bengkel)
                                <img src="{{ asset('storage/' . $workshop->foto_bengkel) }}" alt="{{ $workshop->nama_bengkel }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full bg-red-50 flex flex-col items-center justify-center text-red-400">
                                    <span class="text-xs font-semibold">Foto belum tersedia</span>
                                </div>
                            @endif
                            
                            @if($workshop->jam_buka && $workshop->jam_tutup)
                                @php
                                    $sekarang = \Carbon\Carbon::now('Asia/Jakarta')->format('H:i');
                                    $jamBuka = \Carbon\Carbon::parse($workshop->jam_buka)->format('H:i');
                                    $jamTutup = \Carbon\Carbon::parse($workshop->jam_tutup)->format('H:i');
                                    $sedangBuka = ($sekarang >= $jamBuka && $sekarang <= $jamTutup);
                                @endphp

                                @if($sedangBuka)
                                    <span class="absolute top-3 right-3 bg-green-500 text-white text-[11px] px-2.5 py-1 rounded-full font-bold shadow-sm tracking-wide">
                                        BUKA ⋅ {{ $jamBuka }} - {{ $jamTutup }}
                                    </span>
                                @else
                                    <span class="absolute top-3 right-3 bg-gray-500 text-white text-[11px] px-2.5 py-1 rounded-full font-bold shadow-sm tracking-wide">
                                        TUTUP
                                    </span>
                                @endif
                            @else
                                <span class="absolute top-3 right-3 bg-green-500 text-white text-[11px] px-2.5 py-1 rounded-full font-bold shadow-sm tracking-wide">
                                    BUKA
                                </span>
                            @endif
                        </div>

                        <div class="p-5 flex-1 flex flex-col">
                            <div>
                                <h3 class="font-bold text-lg text-gray-900 line-clamp-1 hover:text-red-600 transition cursor-pointer">
                                    {{ $workshop->nama_bengkel }}
                                </h3>
                                
                                <p class="text-sm text-gray-500 mt-2 line-clamp-2">
                                    {{ $workshop->alamat_bengkel }}
                                </p>
                            </div>
                            
                            <div class="mt-auto pt-3">
                                @if(isset($workshop->jarak))
                                    <div class="flex flex-wrap gap-2">
                                        <div class="inline-flex items-center bg-red-100 text-red-700 px-2.5 py-1 rounded-md text-xs font-bold border border-red-200">
                                            Jarak: {{ number_format($workshop->jarak, 1, ',', '.') }} km
                                        </div>
                                        
                                        @php
                                            // Asumsi kecepatan 30 km/jam (1 km = 2 Menit). Ditambah 5 menit persiapan montir.
                                            $estimasiTiba = round($workshop->jarak * 2) + 5;
                                        @endphp
                                        <div class="inline-flex items-center bg-blue-100 text-blue-800 px-2.5 py-1 rounded-md text-xs font-bold border border-blue-200">
                                            Tiba: {{ $estimasiTiba }} Menit
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="mt-5 pt-4 border-t border-gray-100 flex gap-3">
                                <a href="https://www.google.com/maps/dir/?api=1&destination={{ $workshop->latitude }},{{ $workshop->longitude }}" target="_blank" 
                                   class="flex-1 text-center bg-[#C62828] hover:bg-red-700 text-white text-xs sm:text-sm font-bold py-2.5 rounded-xl transition shadow-sm flex items-center justify-center">
                                    Rute
                                </a>

                                @php
                                    // 1. Ambil nomor dari database
                                    $nomorWa = $workshop->nomor_kontak;
                                    
                                    // 2. Bersihkan semua karakter selain angka (hilangkan spasi, tanda +, strip, dll)
                                    $nomorWa = preg_replace('/[^0-9]/', '', $nomorWa);

                                    // 3. Logika penyesuaian kode negara (Indonesia)
                                    if (str_starts_with($nomorWa, '0')) {
                                        // Jika berawalan 0, ganti 0 dengan 62
                                        $nomorWa = '62' . substr($nomorWa, 1);
                                    } elseif (str_starts_with($nomorWa, '8')) {
                                        // Jika langsung berawalan 8 (seperti kasus error Anda), tambahkan 62 di depannya
                                        $nomorWa = '62' . $nomorWa;
                                    }
                                    // Jika sudah berawalan 62, maka akan dibiarkan saja

                                    // 4. Siapkan link lokasi dan isi pesan
                                    $linkLokasiCustomer = "https://www.google.com/maps/search/?api=1&query=" . request('lat') . "," . request('lng');
                                    $pesanWa = "Halo *" . $workshop->nama_bengkel . "*, saya butuh bantuan darurat. Bisakah montir Anda datang ke lokasi saya? Berikut adalah titik lokasi saya saat ini: " . $linkLokasiCustomer;
                                @endphp
                                
                                <a href="https://wa.me/{{ $nomorWa }}?text={{ urlencode($pesanWa) }}" target="_blank" 
                                   class="flex-1 text-center bg-green-500 hover:bg-green-600 text-white text-xs sm:text-sm font-bold py-2.5 rounded-xl transition shadow-sm flex items-center justify-center">
                                    Chat WA
                                </a>
                            </div>
                        </div>

                    </div>
                @empty
                    <div class="col-span-full py-16 flex flex-col items-center justify-center text-gray-500 bg-white rounded-2xl border border-gray-100 shadow-sm">
                        <p class="text-xl font-bold text-gray-800">Tidak ada bengkel terdekat</p>
                        <p class="text-sm mt-2 text-center max-w-md">Belum ada bengkel yang melayani kategori ini di sekitar Anda. Coba kembali beberapa saat lagi.</p>
                        <a href="{{ route('dashboard') }}?lat={{ request('lat') }}&lng={{ request('lng') }}" class="mt-6 px-6 py-2 bg-red-50 text-red-600 font-semibold rounded-lg hover:bg-red-100 transition">
                            Kembali ke Halaman Utama
                        </a>
                    </div>
                @endforelse
                
            </div>
        </div>
        
    </div>
</x-app-layout>