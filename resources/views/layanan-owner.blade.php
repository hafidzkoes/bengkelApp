<x-app-layout>
    <div class="bg-white min-h-screen pt-6 pb-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-r-xl shadow-sm flex items-center gap-3 transform transition-all duration-300 ease-out">
                    <span class="font-semibold">{{ session('success') }}</span>
                </div>
            @endif

            <div class="mb-8 pb-5">
                <h2 class="text-2xl font-extrabold text-gray-900 tracking-tight">Manajemen Layanan & Operasional</h2>
                <p class="text-sm text-gray-500 mt-1">Atur jam buka otomatis dan layanan yang Anda sediakan di sini.</p>
            </div>

            <form action="{{ route('owner.layanan.update') }}" method="POST">
                @csrf
                
                <div class="bg-gray-50 p-6 md:p-8 rounded-3xl border border-gray-100 shadow-inner">
                    
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        
                        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm space-y-5">
                            <h3 class="font-bold text-gray-900 text-lg border-b border-gray-100 pb-4">
                                Layanan Darurat yang Disediakan
                            </h3>
                            
                            <div class="space-y-4">
                                <label class="flex items-center p-4 rounded-xl border cursor-pointer transition shadow-sm group {{ $workshop->bisa_tambal_ban ? 'border-blue-500 bg-blue-50/50' : 'border-gray-200 bg-white hover:border-blue-200' }}">
                                    <input type="checkbox" name="bisa_tambal_ban" value="1" 
                                        {{ old('bisa_tambal_ban', $workshop->bisa_tambal_ban ?? false) ? 'checked' : '' }}
                                        class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500 focus:ring-offset-0 transition">
                                    <div class="ml-4">
                                        <span class="block text-sm font-bold text-gray-800 group-hover:text-blue-600 transition-colors">Tambal Ban / Ganti Ban</span>
                                        <span class="block text-[11px] text-gray-500 mt-0.5">Centang jika Anda melayani perbaikan ban bocor di lokasi.</span>
                                    </div>
                                </label>

                                <label class="flex items-center p-4 rounded-xl border cursor-pointer transition shadow-sm group {{ $workshop->bisa_perbaikan_mesin ? 'border-blue-500 bg-blue-50/50' : 'border-gray-200 bg-white hover:border-blue-200' }}">
                                    <input type="checkbox" name="bisa_perbaikan_mesin" value="1" 
                                        {{ old('bisa_perbaikan_mesin', $workshop->bisa_perbaikan_mesin ?? false) ? 'checked' : '' }}
                                        class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500 focus:ring-offset-0 transition">
                                    <div class="ml-4">
                                        <span class="block text-sm font-bold text-gray-800 group-hover:text-blue-600 transition-colors">Perbaikan Motor Mogok</span>
                                        <span class="block text-[11px] text-gray-500 mt-0.5">Centang jika Anda melayani perbaikan mesin/kelistrikan darurat.</span>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm space-y-5">
                            <h3 class="font-bold text-gray-900 text-lg border-b border-gray-100 pb-4">
                                Jam Operasional Otomatis
                            </h3>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                <div>
                                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Jam Buka <span class="text-blue-500">*</span></label>
                                    <input type="time" name="jam_buka" 
                                        value="{{ old('jam_buka', $workshop->jam_buka ? date('H:i', strtotime($workshop->jam_buka)) : '') }}" required
                                        class="block w-full rounded-xl border-gray-300 bg-gray-50 focus:bg-white py-3 pl-4 pr-3 focus:border-blue-500 focus:ring-blue-500 text-base font-bold text-gray-900 transition-colors shadow-sm">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Jam Tutup <span class="text-blue-500">*</span></label>
                                    <input type="time" name="jam_tutup" 
                                        value="{{ old('jam_tutup', $workshop->jam_tutup ? date('H:i', strtotime($workshop->jam_tutup)) : '') }}" required
                                        class="block w-full rounded-xl border-gray-300 bg-gray-50 focus:bg-white py-3 pl-4 pr-3 focus:border-blue-500 focus:ring-blue-500 text-base font-bold text-gray-900 transition-colors shadow-sm">
                                </div>
                            </div>
                            
                            <div class="mt-2 p-4 bg-gray-50 rounded-xl border border-gray-100">
                                <p class="text-xs text-gray-500 font-medium leading-relaxed">
                                    <span class="text-blue-600 font-bold block mb-1">Informasi Sistem:</span> 
                                    Status bengkel di aplikasi pelanggan akan otomatis berubah menjadi "Buka" jika waktu saat ini berada di antara jam buka dan jam tutup yang Anda tentukan di atas.
                                </p>
                            </div>
                        </div>

                    </div>

                </div>

                <div class="mt-12 pt-6 flex justify-end">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3.5 rounded-xl shadow-md hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 font-extrabold transition-all duration-300 transform hover:-translate-y-0.5">
                        Simpan Pengaturan
                    </button>
                </div>

            </form>
        </div>
    </div>
</x-app-layout>