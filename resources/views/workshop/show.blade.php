<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Profil Bengkel') }}
            </h2>
            <a href="{{ route('workshop.edit') }}" class="px-4 py-2 bg-indigo-600 text-white text-sm font-semibold rounded-lg hover:bg-indigo-700 transition shadow-sm flex items-center gap-2">
                <span>✏️</span> Edit Profil
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-5 p-4 bg-green-100 border border-green-400 text-green-700 rounded-xl font-semibold shadow-sm flex items-center gap-3">
                    <span class="text-xl">✅</span>
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white shadow-2xl rounded-3xl overflow-hidden border border-gray-100">
                
                <div class="w-full h-80 md:h-96 relative bg-gray-100 flex items-center justify-center overflow-hidden border-b border-gray-100 shadow-inner">
                    @if($workshop && $workshop->foto_bengkel)
                        <img src="{{ asset('storage/' . $workshop->foto_bengkel) }}" alt="Foto Bengkel" class="w-full h-full object-cover">
                    @else
                        <div class="text-gray-400 flex flex-col items-center">
                            <span class="text-6xl mb-3 p-5 bg-gray-50 rounded-full">📸</span>
                            <span class="text-sm font-semibold">Foto bengkel belum diunggah</span>
                        </div>
                    @endif
                </div>
                
                <div class="p-8 md:p-10">
                    <h3 class="text-4xl font-extrabold text-gray-950 tracking-tight">
                        {{ $workshop->nama_bengkel ?? 'Nama Bengkel Belum Diatur' }}
                    </h3>
                    
                    @if($workshop && $workshop->nama_kepala_bengkel)
                        <div class="inline-block px-3 py-1 bg-indigo-50 text-indigo-700 font-semibold rounded-full text-sm mt-2">
                            👤 Kepala Bengkel: {{ $workshop->nama_kepala_bengkel }}
                        </div>
                    @endif

                    <div class="mt-10 grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="p-6 bg-white rounded-2xl border border-gray-100 shadow-inner flex gap-4">
                            <span class="text-3xl p-3 bg-red-50 rounded-2xl h-fit">📍</span>
                            <div>
                                <p class="text-xs text-gray-500 uppercase font-bold tracking-wider mb-1">Alamat Lengkap</p>
                                <p class="font-semibold text-gray-800 leading-relaxed">
                                    {{ $workshop->alamat_bengkel ?? 'Alamat belum diatur. Silakan lengkapi profil.' }}
                                </p>
                            </div>
                        </div>
                        
                        <div class="p-6 bg-white rounded-2xl border border-gray-100 shadow-inner flex gap-4">
                            <span class="text-3xl p-3 bg-green-50 rounded-2xl h-fit">📞</span>
                            <div>
                                <p class="text-xs text-gray-500 uppercase font-bold tracking-wider mb-1">Nomor WhatsApp Aktif</p>
                                <p class="font-bold text-gray-950 text-xl tracking-tight">
                                    {{ $workshop->nomor_kontak ?? 'Nomor belum diatur.' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>