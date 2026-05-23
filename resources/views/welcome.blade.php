<x-app-layout>
    <div class="flex flex-col bg-gray-50 min-h-screen">
        
        <div class="relative bg-[#C62828] min-h-[250px] md:min-h-[300px] flex items-center overflow-hidden shadow-md pb-16 md:pb-24">
            <div class="container mx-auto px-6 md:px-12 flex flex-col md:flex-row items-center justify-between w-full relative z-10 pt-4">
                
                <div class="w-full md:w-3/5 text-center md:text-left py-6">
                    <h1 class="text-3xl md:text-5xl font-extrabold text-white leading-tight tracking-tight">
                        Nikmati hematnya <br class="hidden md:block"> servis kendaraan!
                    </h1>
                    <p class="mt-4 text-red-100 text-lg md:text-xl font-medium max-w-2xl">
                        Jelajahi promo dari bengkel terdekat. Masuk atau Daftar sekarang untuk mulai memanggil montir!
                    </p>
                </div>

                <div class="w-full md:w-2/5 flex justify-center md:justify-end mt-4 md:mt-0 hidden md:flex">
                    <img src="{{ asset('images/logo bengkel.png') }}" alt="Servis Kendaraan" class="w-40 md:w-56 h-auto object-contain transform hover:scale-105 transition duration-500">
                </div>
            </div>
            <div class="absolute top-0 right-0 w-full h-full bg-gradient-to-r from-black/20 to-transparent pointer-events-none z-0"></div>
        </div>

        <div class="container mx-auto px-4 md:px-12 relative -mt-16 md:-mt-20 z-20 mb-20">
            <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="flex justify-center border-b border-gray-200 px-4">
                    <button class="flex items-center gap-2 px-8 py-3 text-red-600 font-bold border-b-2 border-red-600 focus:outline-none">
                        <span class="text-xl">🏍️</span> Motor
                    </button>
                </div>

                <div class="p-5 md:p-6">
                    <div class="grid grid-cols-2 gap-4 md:gap-6 max-w-3xl mx-auto">
                        <a href="{{ route('login') }}" 
                           class="w-full text-center py-4 border border-gray-200 rounded-lg text-base md:text-lg font-semibold text-gray-700 hover:border-red-400 hover:text-red-600 hover:bg-red-50 hover:shadow-sm transition-all focus:outline-none block">
                            ⭕ Ban Bocor
                        </a>
                        <a href="{{ route('login') }}" 
                           class="w-full text-center py-4 border border-gray-200 rounded-lg text-base md:text-lg font-semibold text-gray-700 hover:border-red-400 hover:text-red-600 hover:bg-red-50 hover:shadow-sm transition-all focus:outline-none block">
                            🏍️ Motor Mogok
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="container mx-auto px-4 md:px-12 mb-24 mt-12">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl md:text-2xl font-extrabold text-gray-800 tracking-tight">
                    Mitra Bengkel Kami
                </h2>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @forelse($workshops as $workshop)
                    <div class="bg-white rounded-2xl shadow-md overflow-hidden border border-gray-100 hover:shadow-xl transition-all duration-300 flex flex-col opacity-90">
                        
                        <div class="h-44 w-full bg-gray-100 relative overflow-hidden flex-shrink-0">
                            @if($workshop->foto_bengkel)
                                <img src="{{ asset('storage/' . $workshop->foto_bengkel) }}" alt="{{ $workshop->nama_bengkel }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full bg-red-50 flex flex-col items-center justify-center text-red-400">
                                    <span class="text-4xl mb-1">🚗</span>
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
                                        BUKA
                                    </span>
                                @else
                                    <span class="absolute top-3 right-3 bg-gray-500 text-white text-[11px] px-2.5 py-1 rounded-full font-bold shadow-sm tracking-wide">
                                        TUTUP
                                    </span>
                                @endif
                            @endif
                        </div>

                        <div class="p-5 flex-1 flex flex-col justify-between">
                            <div>
                                <h3 class="font-bold text-lg text-gray-900 line-clamp-1">
                                    {{ $workshop->nama_bengkel }}
                                </h3>
                                <p class="text-sm text-gray-500 mt-2 line-clamp-2 flex items-start gap-1">
                                    <span class="text-gray-400 flex-shrink-0">📍</span>
                                    {{ $workshop->alamat_bengkel }}
                                </p>
                            </div>

                            <div class="mt-5 pt-4 border-t border-gray-100">
                                <a href="{{ route('login') }}" class="block w-full text-center bg-gray-100 hover:bg-red-600 text-gray-700 hover:text-white text-sm font-bold py-2.5 rounded-xl transition shadow-sm flex items-center justify-center gap-2 border border-gray-200">
                                    <span>🔒</span> Login untuk Memesan
                                </a>
                            </div>
                        </div>

                    </div>
                @empty
                    <div class="col-span-full py-10 flex flex-col items-center justify-center text-gray-500 bg-white rounded-2xl border border-gray-100">
                        <span class="text-5xl mb-3">🛠️</span>
                        <p class="text-lg font-bold">Belum ada bengkel mitra yang terdaftar.</p>
                    </div>
                @endforelse
            </div>
        </div>

        @if(View::exists('layouts.footer'))
            @include('layouts.footer')
        @endif

    </div>
</x-app-layout>