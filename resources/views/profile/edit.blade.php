<x-app-layout>
    <div class="bg-gray-50 min-h-screen py-10 md:py-16">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            
            <div class="mb-2 border-b border-gray-100 pb-6">
                <h2 class="text-2xl font-extrabold text-gray-900 tracking-tight">
                    Pengaturan Akun
                </h2>
                <p class="mt-2 text-sm text-gray-500">
                    @if(auth()->user()->role == 'owner' || auth()->user()->role == 'admin')
                        Perbarui kata sandi Anda untuk memastikan akun bengkel tetap aman.
                    @else
                        Kelola informasi profil Anda untuk mengontrol, melindungi dan mengamankan akun.
                    @endif
                </p>
            </div>

            @if(auth()->user()->role == 'customer' || auth()->user()->role == 'user')
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-8">
                <div class="p-6 md:p-10">
                    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('patch')

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
                            <input id="phone" name="phone" type="text" placeholder="Contoh: 6281234567890" class="block w-full border-gray-200 focus:border-red-500 focus:ring-red-500 rounded-xl shadow-sm px-4 py-3 transition text-gray-800" value="{{ old('phone', $user->phone ?? '') }}">
                            <p class="mt-1.5 text-xs text-gray-400 font-medium">Gunakan format 62 (pengganti angka 0 di depan).</p>
                        </div>

                        <div>
                            <label for="photo" class="block text-sm font-bold text-gray-700 mb-2">Foto Pengguna <span class="text-gray-400 font-normal">(Opsional)</span></label>
                            <div class="mt-1">
                                <input id="photo" name="photo" type="file" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-bold file:bg-red-50 file:text-red-600 hover:file:bg-red-100 transition shadow-sm border border-gray-100 rounded-xl bg-white cursor-pointer">
                            </div>
                        </div>

                        <div class="pt-6">
                            <button type="submit" class="w-full sm:w-auto bg-red-600 hover:bg-red-700 text-white px-8 py-3.5 rounded-xl font-bold transition-colors shadow-md text-sm md:text-base">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            @endif

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 md:p-10">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

        </div>
    </div>
</x-app-layout>