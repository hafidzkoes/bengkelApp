<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profil Pengguna') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            
            <!-- KARTU PROFIL -->
            <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-100">
                <div class="bg-gradient-to-r from-indigo-500 to-purple-600 h-32 relative">
                    <div class="absolute -bottom-12 left-8">
                        <div class="w-24 h-24 rounded-2xl border-4 border-white bg-white shadow-md flex items-center justify-center overflow-hidden">
                            @if(auth()->user()->photo)
                                <!-- Menampilkan foto asli dari database -->
                                <img src="{{ asset('storage/' . auth()->user()->photo) }}" alt="Foto Profil" class="w-full h-full object-cover">
                            @else
                                <!-- Jika tidak ada foto, tampilkan inisial nama -->
                                <div class="w-full h-full bg-indigo-100 flex items-center justify-center">
                                    <span class="text-3xl font-bold text-indigo-600">
                                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                    </span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                
                <div class="pt-16 pb-8 px-8">
                    <h3 class="text-2xl font-bold text-gray-900">{{ auth()->user()->name }}</h3>
                    <p class="text-indigo-600 font-medium capitalize">{{ auth()->user()->role }}</p>

                    <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="p-4 bg-gray-50 rounded-xl">
                            <p class="text-xs text-gray-500 uppercase">Email</p>
                            <p class="font-semibold text-gray-800">{{ auth()->user()->email }}</p>
                        </div>
                        <div class="p-4 bg-gray-50 rounded-xl">
                            <p class="text-xs text-gray-500 uppercase">Nomor HP</p>
                            <p class="font-semibold text-gray-800">{{ auth()->user()->phone ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>