<x-app-layout>
    <div class="p-6 space-y-6 max-w-4xl mx-auto">
        
        <div class="border-b border-gray-200 pb-4">
            <h1 class="text-2xl font-bold text-gray-800">Manajemen Layanan & Operasional</h1>
            <p class="text-sm text-gray-500 mt-1">Atur jam buka otomatis dan layanan yang Anda sediakan di sini.</p>
        </div>

        @if(session('success'))
            <div class="p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg font-semibold">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('owner.layanan.update') }}" method="POST" class="space-y-6">
            @csrf

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <span>🕒</span> Jam Operasional Otomatis
                </h2>
                <p class="text-sm text-gray-500 mb-4">Status bengkel di aplikasi pelanggan akan otomatis berubah menjadi "Buka" jika waktu saat ini berada di antara jam buka dan jam tutup.</p>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Jam Buka</label>
                        <input type="time" name="jam_buka" 
                               value="{{ $workshop->jam_buka ? date('H:i', strtotime($workshop->jam_buka)) : '' }}" 
                               class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Jam Tutup</label>
                        <input type="time" name="jam_tutup" 
                               value="{{ $workshop->jam_tutup ? date('H:i', strtotime($workshop->jam_tutup)) : '' }}" 
                               class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100 bg-gray-50/50">
                    <h2 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                        <span>🔧</span> Layanan Darurat yang Disediakan
                    </h2>
                </div>
                
                <div class="p-6 space-y-4">
                    <label class="flex items-center p-4 border rounded-xl cursor-pointer transition hover:bg-gray-50 {{ $workshop->bisa_tambal_ban ? 'border-indigo-500 bg-indigo-50/30' : 'border-gray-200' }}">
                        <input type="checkbox" name="bisa_tambal_ban" class="w-5 h-5 text-indigo-600 rounded focus:ring-indigo-500" {{ $workshop->bisa_tambal_ban ? 'checked' : '' }}>
                        <div class="ml-4">
                            <span class="block font-bold text-gray-800">Tambal Ban / Ganti Ban</span>
                            <span class="block text-sm text-gray-500">Centang jika Anda melayani perbaikan ban bocor di lokasi.</span>
                        </div>
                    </label>

                    <label class="flex items-center p-4 border rounded-xl cursor-pointer transition hover:bg-gray-50 {{ $workshop->bisa_perbaikan_mesin ? 'border-indigo-500 bg-indigo-50/30' : 'border-gray-200' }}">
                        <input type="checkbox" name="bisa_perbaikan_mesin" class="w-5 h-5 text-indigo-600 rounded focus:ring-indigo-500" {{ $workshop->bisa_perbaikan_mesin ? 'checked' : '' }}>
                        <div class="ml-4">
                            <span class="block font-bold text-gray-800">Perbaikan Motor Mogok</span>
                            <span class="block text-sm text-gray-500">Centang jika Anda melayani perbaikan mesin/kelistrikan darurat.</span>
                        </div>
                    </label>
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-indigo-600 text-white px-8 py-3 rounded-xl hover:bg-indigo-700 transition font-bold shadow-md">
                    Simpan Pengaturan
                </button>
            </div>
        </form>

    </div>
</x-app-layout>