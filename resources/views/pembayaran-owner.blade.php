<x-app-layout>
    
<style>
        /* Menghilangkan panah untuk Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
        /* Menghilangkan panah untuk Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }
    </style>

    <div class="p-6 space-y-6 max-w-4xl mx-auto">
        
        <div class="border-b border-gray-200 pb-4">
            <h1 class="text-2xl font-bold text-gray-800">Manajemen Tarif & Status Pembayaran</h1>
            <p class="text-sm text-gray-500 mt-1">Tentukan estimasi biaya jasa panggilan dan atur tampilannya di dashboard.</p>
        </div>

        @if(session('success'))
            <div class="p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg font-semibold">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('owner.pembayaran.update') }}" method="POST" class="space-y-6">
            @csrf

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 space-y-6">
                <h2 class="text-lg font-bold text-gray-800 flex items-center gap-2 border-b pb-3">
                    <span>💰</span> Pengaturan Tarif Jasa
                </h2>

                <div class="p-4 rounded-xl border border-gray-200 space-y-4">
                    <div class="flex justify-between items-center flex-wrap gap-2">
                        <label class="font-bold text-gray-800 text-base flex items-center gap-2">
                            <span>⭕</span> Tarif Jasa Ban Bocor
                        </label>
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="tampilkan_harga_ban" value="1" {{ ($workshop->tampilkan_harga_ban ?? true) ? 'checked' : '' }} class="rounded text-indigo-600 focus:ring-indigo-500">
                            <span class="ml-2 text-xs font-semibold text-gray-500">Tampilkan Status di Dashboard</span>
                        </label>
                    </div>
                    <div>
                        <div class="relative mt-1 rounded-md shadow-sm max-w-md">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <span class="text-gray-500 sm:text-sm">Rp</span>
                            </div>
                            <input type="number" name="harga_tambal_ban" value="{{ $workshop->harga_tambal_ban ?? 0 }}" class="block w-full rounded-md border-gray-300 pl-10 pr-4 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="0">
                        </div>
                    </div>
                </div>

                <div class="p-4 rounded-xl border border-gray-200 space-y-4">
                    <div class="flex justify-between items-center flex-wrap gap-2">
                        <label class="font-bold text-gray-800 text-base flex items-center gap-2">
                            <span>🏍️</span> Tarif Jasa Motor Mogok
                        </label>
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="tampilkan_harga_mesin" value="1" {{ ($workshop->tampilkan_harga_mesin ?? true) ? 'checked' : '' }} class="rounded text-indigo-600 focus:ring-indigo-500">
                            <span class="ml-2 text-xs font-semibold text-gray-500">Tampilkan Status di Dashboard</span>
                        </label>
                    </div>
                    <div>
                        <div class="relative mt-1 rounded-md shadow-sm max-w-md">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <span class="text-gray-500 sm:text-sm">Rp</span>
                            </div>
                            <input type="number" name="harga_perbaikan_mesin" value="{{ $workshop->harga_perbaikan_mesin ?? 0 }}" class="block w-full rounded-md border-gray-300 pl-10 pr-4 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="0">
                        </div>
                    </div>
                </div>

            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-indigo-600 text-white px-8 py-3 rounded-xl hover:bg-indigo-700 transition font-bold shadow-md">
                    Simpan Pengaturan Pembayaran
                </button>
            </div>
        </form>

    </div>
</x-app-layout>