<x-app-layout>
    <div class="flex flex-col bg-gray-50 min-h-screen">
        
        <div class="relative bg-[#C62828] min-h-[200px] md:min-h-[280px] flex items-center overflow-hidden shadow-md pb-12 md:pb-16">
            
            <div class="container mx-auto px-4 md:px-12 flex flex-row items-center justify-between w-full relative z-10 pt-4">
                
                <div class="w-[60%] text-left py-6 pr-2 md:pr-4">
                    <h1 class="text-xl sm:text-3xl md:text-5xl font-extrabold text-white leading-tight tracking-tight">
                        Nikmati hematnya <br class="hidden md:block"> servis kendaraan!
                    </h1>
                    <p class="mt-2 md:mt-4 text-red-100 text-xs sm:text-base md:text-xl font-medium max-w-2xl leading-snug">
                        Solusi cepat saat darurat. Masuk atau Daftar sekarang untuk memanggil montir terdekat!
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
        
                        <a href="{{ route('login') }}" 
                           class="w-full text-center py-3 border border-gray-200 rounded-lg text-sm md:text-base font-bold text-gray-700 hover:border-red-400 hover:text-red-600 hover:bg-red-50 hover:shadow-sm transition-all focus:outline-none block">
                            Ban Bocor
                        </a>

                        <a href="{{ route('login') }}" 
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
                    Mitra Bengkel Kami
                </h2>
                <a href="{{ route('login') }}" class="inline-flex justify-center items-center px-6 py-2 bg-red-600 hover:bg-red-700 text-white text-xs sm:text-sm font-bold rounded-full transition-colors shadow-md flex-shrink-0 text-center">
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
                            </div>

                            <div class="mt-5 pt-4 border-t border-gray-100">
                                <a href="{{ route('login') }}" class="block w-full text-center bg-[#C62828] hover:bg-red-700 text-white text-sm font-bold py-2.5 rounded-xl transition shadow-sm flex items-center justify-center">
                                    Login untuk Memesan
                                </a>
                            </div>
                        </div>

                    </div>
                @empty
                    <div class="col-span-full py-10 flex flex-col items-center justify-center text-gray-500 bg-white rounded-2xl border border-gray-100 border-dashed">
                        <p class="text-lg font-bold text-gray-700">Belum ada mitra bengkel.</p>
                    </div>
                @endforelse
                
            </div>
        </div>

        @if(View::exists('layouts.footer'))
            @include('layouts.footer')
        @endif

    </div>
</x-app-layout>