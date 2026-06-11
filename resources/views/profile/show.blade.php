<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profil Pengguna') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            
            @if(auth()->user()->role === 'customer')
            <div class="mb-6">
                <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-red-600 hover:bg-red-700 rounded-xl shadow-sm text-sm font-bold text-white transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                    </svg>
                    Kembali ke Dashboard
                </a>
            </div>
            @endif

            <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-100">
                <div class="bg-gradient-to-r from-indigo-500 to-purple-600 h-32 relative">
                    <div class="absolute -bottom-12 left-8">
                        <div class="w-24 h-24 rounded-2xl border-4 border-white bg-white shadow-md flex items-center justify-center overflow-hidden">
                            @if(auth()->user()->photo)
                                <img src="{{ asset('storage/' . auth()->user()->photo) }}" alt="Foto Profil" class="w-full h-full object-cover">
                            @else
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
                    <p class="text-indigo-600 font-medium capitalize">
                       {{ auth()->user()->role === 'customer' ? 'Pengguna' : auth()->user()->role }}
                    </p>

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