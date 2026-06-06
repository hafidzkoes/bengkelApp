<x-app-layout>
    
    <style>
        /* Menghilangkan panah spinner pada input number agar tampilan bersih */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
        input[type=number] {
            -moz-appearance: textfield;
        }
    </style>

    <div class="bg-white min-h-screen pt-6 pb-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-r-xl shadow-sm flex items-center gap-3 transform transition-all duration-300 ease-out">
                    <span class="text-xl">✅</span>
                    <span class="font-semibold">{{ session('success') }}</span>
                </div>
            @endif

            <div class="mb-8 pb-5">
                <h1 class="text-2xl font-extrabold text-gray-900 tracking-tight">Manajemen Tarif & Status Pembayaran</h1>
                <p class="text-sm text-gray-500 mt-1">Tentukan estimasi biaya jasa panggilan dan atur tampilannya di dashboard.</p>
            </div>

            <form action="{{ route('owner.pembayaran.update') }}" method="POST">
                @csrf

                <div class="bg-gray-50 p-6 md:p-8 rounded-3xl border border-gray-100 shadow-inner">
                    
                    <h2 class="text-lg font-bold text-gray-900 tracking-tight mb-4">
                        Pengaturan Tarif Jasa
                    </h2>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        
                        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm space-y-5 transition hover:border-blue-200">
                            
                            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-2">
                                <label class="font-bold text-gray-800 text-base">Tarif Jasa Ban Bocor</label>
                                <label class="inline-flex items-center cursor-pointer group">
                                    <input type="checkbox" name="tampilkan_harga_ban" value="1" {{ ($workshop->tampilkan_harga_ban ?? true) ? 'checked' : '' }} 
                                           class="w-5 h-5 rounded text-blue-600 focus:ring-blue-500 border-gray-300 transition">
                                    <span class="ml-2.5 text-xs font-semibold text-gray-500 group-hover:text-gray-900 transition-colors">Tampilkan di Dashboard</span>
                                </label>
                            </div>
                            
                            <div>
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Nominal Harga (Rp)</label>
                                <div class="relative rounded-xl shadow-sm max-w-md">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                                        <span class="text-gray-500 sm:text-base font-bold">Rp</span>
                                    </div>
                                    <input type="number" name="harga_tambal_ban" value="{{ $workshop->harga_tambal_ban ?? 0 }}" 
                                           class="block w-full rounded-xl border-gray-300 pl-12 pr-4 py-3 focus:border-blue-500 focus:ring-blue-500 text-base font-bold text-gray-900" placeholder="0">
                                </div>
                            </div>

                        </div>

                        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm space-y-5 transition hover:border-blue-200">
                            
                            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-2">
                                <label class="font-bold text-gray-800 text-base">Tarif Jasa Motor Mogok</label>
                                <label class="inline-flex items-center cursor-pointer group">
                                    <input type="checkbox" name="tampilkan_harga_mesin" value="1" {{ ($workshop->tampilkan_harga_mesin ?? true) ? 'checked' : '' }} 
                                           class="w-5 h-5 rounded text-blue-600 focus:ring-blue-500 border-gray-300 transition">
                                    <span class="ml-2.5 text-xs font-semibold text-gray-500 group-hover:text-gray-900 transition-colors">Tampilkan di Dashboard</span>
                                </label> </div>
                            
                            <div>
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Nominal Harga (Rp)</label>
                                <div class="relative rounded-xl shadow-sm max-w-md">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                                        <span class="text-gray-500 sm:text-base font-bold">Rp</span>
                                    </div>
                                    <input type="number" name="harga_perbaikan_mesin" value="{{ $workshop->harga_perbaikan_mesin ?? 0 }}" 
                                           class="block w-full rounded-xl border-gray-300 pl-12 pr-4 py-3 focus:border-blue-500 focus:ring-blue-500 text-base font-bold text-gray-900" placeholder="0">
                                </div>
                            </div>

                        </div>

                    </div>

                </div>

                <div class="mt-12 pt-6 flex justify-end">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3.5 rounded-xl shadow-md hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 font-extrabold transition-all duration-300 transform hover:-translate-y-0.5">
                        Simpan Pengaturan Pembayaran
                    </button>
                </div>

            </form>

        </div>
    </div>
</x-app-layout>