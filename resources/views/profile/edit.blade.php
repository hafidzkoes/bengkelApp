<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Profil Pengguna') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8">
                
                <!-- Form Edit Profil -->
                <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('patch')

                    <!-- Nama Lengkap -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap *</label>
                        <input id="name" name="name" type="text" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" value="{{ old('name', $user->name) }}" required autofocus>
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email *</label>
                        <input id="email" name="email" type="email" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" value="{{ old('email', $user->email) }}" required>
                    </div>

                    <!-- Nomor HP -->
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700">Nomor WhatsApp / HP (Awali dengan 62...)</label>
                        <input id="phone" name="phone" type="text" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" value="{{ old('phone', $user->phone ?? '') }}">
                    </div>

                    <!-- Foto Pengguna -->
                    <div>
                        <label for="photo" class="block text-sm font-medium text-gray-700">Foto Pengguna (Opsional)</label>
                        <input id="photo" name="photo" type="file" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                    </div>

                    <!-- Tombol Simpan (Warna Biru/Indigo) -->
                    <div class="flex items-center justify-end mt-8">
                        <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-md hover:bg-indigo-700 transition font-semibold">
                            Simpan Profil Pengguna
                        </button>
                    </div>
                </form>

            </div>

            <!-- Ganti Password & Hapus Akun (Opsional, ditaruh di bawah jika mau) -->
            <hr class="my-8 border-gray-300">
            <div class="bg-white shadow sm:rounded-lg p-8 mb-6">
                @include('profile.partials.update-password-form')
            </div>
        </div>
    </div>
</x-app-layout>