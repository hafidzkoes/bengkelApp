<x-app-layout>
    <div class="flex flex-col bg-gray-50 min-h-screen">
        
        <div class="relative bg-[#C62828] min-h-[200px] md:min-h-[280px] flex items-center overflow-hidden shadow-md pb-12 md:pb-16">
            
            <div class="container mx-auto px-4 md:px-12 flex flex-row items-center justify-between w-full relative z-10 pt-4">
                
                <div class="w-[60%] text-left py-6 pr-2 md:pr-4">
                    <h1 class="text-xl sm:text-3xl md:text-5xl font-extrabold text-white leading-tight tracking-tight">
                        Nikmati hematnya <br class="hidden md:block"> servis kendaraan!
                    </h1>
                    <p class="mt-2 md:mt-4 text-red-100 text-xs sm:text-base md:text-xl font-medium max-w-2xl leading-snug">
                        Jelajahi promo dari bengkel terdekat dan booking sekarang!
                    </p>
                </div>

                <div class="w-[40%] flex justify-end items-center">
                    <img src="{{ asset('images/logo bengkel.png') }}" alt="Servis Kendaraan" class="w-28 sm:w-40 md:w-52 h-auto object-contain transform hover:scale-105 transition duration-500">
                </div>

            </div>

            <div class="absolute top-0 right-0 w-full h-full bg-gradient-to-r from-black/20 to-transparent pointer-events-none z-0"></div>
        </div>

        <div class="max-w-4xl mx-auto px-4 md:px-8 relative -mt-8 md:-mt-10 z-20 mb-16 w-full">
            
            <div class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden">
                
                <div class="flex justify-center border-b border-gray-200 px-4">
                    <button class="px-8 py-3 text-red-600 font-bold border-b-2 border-red-600 focus:outline-none">
                        Motor
                    </button>
                </div>

                <div class="p-4 md:p-6">
                    <div class="grid grid-cols-2 gap-4 max-w-xl mx-auto">
        
                        <a href="#" onclick="pindahKeLayanan('ban_bocor')" 
                           class="w-full text-center py-3 border border-gray-200 rounded-lg text-sm md:text-base font-bold text-gray-700 hover:border-red-400 hover:text-red-600 hover:bg-red-50 hover:shadow-sm transition-all focus:outline-none block">
                            Ban Bocor
                        </a>

                        <a href="#" onclick="pindahKeLayanan('perbaikan_mesin')" 
                           class="w-full text-center py-3 border border-gray-200 rounded-lg text-sm md:text-base font-bold text-gray-700 hover:border-red-400 hover:text-red-600 hover:bg-red-50 hover:shadow-sm transition-all focus:outline-none block">
                            Motor Mogok
                        </a>

                    </div>
                </div>

            </div>
        </div>

        <div class="container mx-auto px-4 md:px-12 mb-24 mt-4">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl md:text-2xl font-extrabold text-gray-800 tracking-tight">
                    Rekomendasi Bengkel Terdekat
                </h2>
                <a href="#" onclick="pindahKeLihatSemua()" class="inline-flex justify-center items-center px-6 py-2 bg-red-600 hover:bg-red-700 text-white text-xs sm:text-sm font-bold rounded-full transition-colors shadow-md flex-shrink-0 text-center">
                    Lihat Semua
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                
                @forelse($workshops as $workshop)
                    <div class="bg-white rounded-2xl shadow-md overflow-hidden border border-gray-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col">
                        
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

                        <div class="p-5 flex-1 flex flex-col justify-between">
                            <div>
                                <h3 class="font-bold text-lg text-gray-900 line-clamp-1 hover:text-red-600 transition cursor-pointer">
                                    {{ $workshop->nama_bengkel }}
                                </h3>
                                
                                <p class="text-sm text-gray-500 mt-2 line-clamp-2">
                                    {{ $workshop->alamat_bengkel }}
                                </p>

                                @if(isset($workshop->jarak))
                                    <div class="mt-3 inline-flex items-center bg-red-100 text-red-700 px-2.5 py-1 rounded-md text-xs font-bold border border-red-200">
                                        Jarak: {{ number_format($workshop->jarak, 1, ',', '.') }} km
                                    </div>
                                @endif
                            </div>

                            <div class="mt-5 pt-4 border-t border-gray-100">
                                <a href="https://www.google.com/maps/dir/?api=1&destination={{ $workshop->latitude }},{{ $workshop->longitude }}" target="_blank" class="block w-full text-center bg-[#C62828] hover:bg-red-700 text-white text-sm font-bold py-2.5 rounded-xl transition shadow-sm flex items-center justify-center">
                                    Kunjungi Bengkel
                                </a>
                            </div>
                        </div>

                    </div>
                @empty
                    <div class="col-span-full py-10 flex flex-col items-center justify-center text-gray-500 bg-white rounded-2xl border border-gray-100 px-4 text-center">
                        <p class="text-lg font-bold">Belum ada bengkel terdekat yang ditemukan.</p>
                        <p class="text-sm mt-1">Sistem sedang melacak lokasi Anda. Jika tidak muncul, pastikan GPS Anda aktif.</p>
                    </div>
                @endforelse
                
            </div>
        </div>

        @include('layouts.footer')

    </div>

    <div id="modal-lokasi" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-70 backdrop-blur-sm px-4">
        <div class="bg-white rounded-3xl shadow-2xl max-w-sm w-full p-6 md:p-8 text-center transform transition-all">
            
            <div class="w-20 h-20 bg-red-50 rounded-full flex items-center justify-center mx-auto mb-5 border-4 border-red-100">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-10 h-10 text-red-500">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                </svg>
            </div>
            
            <h3 class="text-xl font-extrabold text-gray-900 mb-2">Akses Lokasi Dibutuhkan</h3>
            <p class="text-sm text-gray-600 mb-8 leading-relaxed">
                Untuk mencarikan bengkel terdekat, BengkelApp butuh izin lokasi Anda. Silakan nyalakan GPS di HP Anda dan izinkan akses di *browser*.
            </p>
            
            <div class="flex flex-col gap-3">
                <button onclick="cobaLacakLokasi()" class="w-full bg-[#C62828] hover:bg-red-700 text-white font-bold py-3.5 rounded-xl transition shadow-md uppercase tracking-wide text-sm">
                    Coba Aktifkan Lokasi
                </button>
                <button onclick="tutupModalLokasi()" class="w-full bg-gray-100 hover:bg-gray-200 text-gray-500 font-bold py-3.5 rounded-xl transition uppercase tracking-wide text-sm">
                    Nanti Saja
                </button>
            </div>
        </div>
    </div>

    <script>
        const urlParams = new URLSearchParams(window.location.search);
        const latDiUrl = urlParams.get('lat');
        const lngDiUrl = urlParams.get('lng');
        const modalLokasi = document.getElementById('modal-lokasi');

        document.addEventListener('DOMContentLoaded', function() {
            // Jika di URL tidak ada kordinat, kita mulai melacak
            if (!latDiUrl || !lngDiUrl) {
                lacakLokasiAwal();
            }
        });

        // FUNGSI MELACAK LOKASI SAAT HALAMAN DIBUKA
        function lacakLokasiAwal() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        // SUKSES! Simpan ke localStorage lalu refresh halaman
                        localStorage.setItem('user_lat', position.coords.latitude);
                        localStorage.setItem('user_lng', position.coords.longitude);
                        window.location.href = window.location.pathname + '?lat=' + position.coords.latitude + '&lng=' + position.coords.longitude;
                    }, 
                    function(error) {
                        console.log("GPS Ditolak/Mati. Error Code:", error.code);
                        
                        // Cek apakah ada sisa koordinat kemaren di HP?
                        const savedLat = localStorage.getItem('user_lat');
                        const savedLng = localStorage.getItem('user_lng');
                        
                        if (savedLat && savedLng) {
                            // Kalau ada sisa kemarin, pakai itu saja diam-diam
                            window.location.href = window.location.pathname + '?lat=' + savedLat + '&lng=' + savedLng;
                        } else {
                            // Kalau bener-bener kosong, TAMPILKAN POP-UP PERINGATAN!
                            modalLokasi.classList.remove('hidden');
                        }
                    },
                    { enableHighAccuracy: true, timeout: 5000 } // Batas waktu pencarian 5 detik
                );
            }
        }

        // FUNGSI TOMBOL "COBA AKTIFKAN LOKASI" (MEMANCING GPS ULANG)
        function cobaLacakLokasi() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        localStorage.setItem('user_lat', position.coords.latitude);
                        localStorage.setItem('user_lng', position.coords.longitude);
                        window.location.href = window.location.pathname + '?lat=' + position.coords.latitude + '&lng=' + position.coords.longitude;
                    }, 
                    function(error) {
                        alert("Gagal melacak! Pastikan fitur Lokasi (GPS) di HP Anda sudah dinyalakan, lalu coba lagi.");
                        // Siasat: Kadang me-refresh halaman memicu browser untuk bertanya izin GPS lagi
                        window.location.reload();
                    },
                    { enableHighAccuracy: true, timeout: 5000 }
                );
            }
        }

        function tutupModalLokasi() {
            modalLokasi.classList.add('hidden');
        }

        // FUNGSI SAAT TOMBOL LAYANAN DIKLIK
        function pindahKeLayanan(layanan) {
            let lat = urlParams.get('lat') || localStorage.getItem('user_lat') || '';
            let lng = urlParams.get('lng') || localStorage.getItem('user_lng') || '';

            if (lat && lng) {
                window.location.href = "{{ route('cari.bengkel') }}?lat=" + lat + "&lng=" + lng + "&layanan=" + layanan;
            } else {
                modalLokasi.classList.remove('hidden'); // Munculkan pop-up kalau maksa klik tapi belum ada GPS
            }
        }

        // FUNGSI SAAT TOMBOL LIHAT SEMUA DIKLIK
        function pindahKeLihatSemua() {
            let lat = urlParams.get('lat') || localStorage.getItem('user_lat') || '';
            let lng = urlParams.get('lng') || localStorage.getItem('user_lng') || '';

            if (lat && lng) {
                window.location.href = "{{ route('cari.bengkel') }}?lat=" + lat + "&lng=" + lng;
            } else {
                modalLokasi.classList.remove('hidden'); // Munculkan pop-up kalau maksa klik tapi belum ada GPS
            }
        }
    </script>
</x-app-layout>