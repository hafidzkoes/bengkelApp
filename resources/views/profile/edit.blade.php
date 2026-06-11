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

    <div class="bg-gray-50 min-h-screen py-10 md:py-16">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            
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
            
            <div class="mb-6 border-b border-gray-200 pb-4">
                <h2 class="text-2xl font-extrabold text-gray-900 tracking-tight">
                    Pengaturan Akun
                </h2>
                <p class="mt-2 text-sm text-gray-500">
                    @if(auth()->user()->role == 'owner' || auth()->user()->role == 'admin')
                        Perbarui alamat email dan kata sandi Anda untuk memastikan akun bengkel tetap aman.
                    @else
                        Kelola informasi profil Anda untuk mengontrol, melindungi dan mengamankan akun.
                    @endif
                </p>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-8">
                <div class="p-6 md:p-10">
                    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('patch')

                        @if(auth()->user()->role === 'owner' || auth()->user()->role === 'admin')
                            <input type="hidden" name="name" value="{{ old('name', $user->name) }}">

                            <div>
                                <label for="email" class="block text-sm font-bold text-gray-700 mb-2">Email Login <span class="text-red-500">*</span></label>
                                <input id="email" name="email" type="email" class="block w-full border-gray-200 focus:border-red-500 focus:ring-red-500 rounded-xl shadow-sm px-4 py-3 transition text-gray-800" value="{{ old('email', $user->email) }}" required>
                            </div>

                        @else
                            <div>
                                <label for="name" class="block text-sm font-bold text-gray-700 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                                <input id="name" name="name" type="text" class="block w-full border-gray-200 focus:border-red-500 focus:ring-red-500 rounded-xl shadow-sm px-4 py-3 transition text-gray-800" value="{{ old('name', $user->name) }}" required autofocus>
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-bold text-gray-700 mb-2">Email <span class="text-red-500">*</span></label>
                                <input id="email" name="email" type="email" class="block w-full border-gray-200 focus:border-red-500 focus:ring-red-500 rounded-xl shadow-sm px-4 py-3 transition text-gray-800" value="{{ old('email', $user->email) }}" required>
                            </div>

                            <div>
                                <label for="phone" class="block text-sm font-bold text-gray-700 mb-2">Nomor WhatsApp / HP</label>
                                <div class="relative rounded-xl shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm font-bold">+62</span>
                                    </div>
                                    <input id="phone" name="phone" type="number" placeholder="81234567890" 
                                        class="block w-full pl-12 border-gray-200 focus:border-red-500 focus:ring-red-500 rounded-xl shadow-sm py-3 transition text-gray-800" 
                                        value="{{ old('phone', str_starts_with($user->phone ?? '', '62') ? substr($user->phone, 2) : ($user->phone ?? '')) }}">
                                </div>
                                <p class="mt-1.5 text-xs text-gray-400 font-medium">Gunakan nomor yang aktif dan terhubung dengan WhatsApp.</p>
                            </div>

                            <div>
                                <label for="photo" class="block text-sm font-bold text-gray-700 mb-2">Foto Pengguna <span class="text-gray-400 font-normal">(Opsional)</span></label>
                                <div class="mt-1">
                                    <input id="photo" name="photo" type="file" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-bold file:bg-red-50 file:text-red-600 hover:file:bg-red-100 transition shadow-sm border border-gray-100 rounded-xl bg-white cursor-pointer">
                                </div>
                            </div>
                        @endif

                        <div class="pt-6 border-t border-gray-100 mt-6">
                            <button type="submit" class="w-full sm:w-auto bg-red-600 hover:bg-red-700 text-white px-8 py-3.5 rounded-xl font-bold transition-colors shadow-md text-sm md:text-base">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 md:p-10">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const phoneInput = document.getElementById('phone');
            if (phoneInput) {
                phoneInput.addEventListener('input', function (e) {
                    let nilaiInput = e.target.value;

                    // Jika angka pertama yang diketik adalah '0', langsung hapus
                    if (nilaiInput.startsWith('0')) {
                        e.target.value = nilaiInput.substring(1);
                    }
                    
                    // Jika angka yang diketik di awal adalah '62', langsung hapus
                    if (nilaiInput.startsWith('62')) {
                        e.target.value = nilaiInput.substring(2);
                    }
                });
            }
        });
    </script>
</x-app-layout>