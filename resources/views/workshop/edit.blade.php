<x-app-layout>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Pemilik Bengkel') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <h3 class="text-lg font-bold mb-4 text-gray-800">Lengkapi Profil Bengkel Anda</h3>

                @if(session('success'))
                    <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('workshop.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="grid grid-cols-1 gap-6 mt-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nama Bengkel *</label>
                            <input type="text" name="nama_bengkel" 
                                value="{{ old('nama_bengkel', $workshop->nama_bengkel ?? '') }}" 
                                required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Alamat Lengkap *</label>
                            <textarea name="alamat_bengkel" rows="3" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('alamat_bengkel', $workshop->alamat_bengkel ?? '') }}</textarea>
                        </div>

                        <div class="mt-2 p-4 border border-gray-200 rounded-xl bg-gray-50">
                            <label class="block font-semibold text-sm text-gray-700 mb-2">
                                📍 Titik Lokasi Peta (Klik pada peta untuk menancapkan pin)
                            </label>
                            
                            <div id="map" style="height: 350px; z-index: 1;" class="w-full rounded-lg shadow-inner border border-gray-300"></div>
                            
                            <input type="hidden" name="latitude" id="latitude" value="{{ $workshop->latitude ?? '' }}">
                            <input type="hidden" name="longitude" id="longitude" value="{{ $workshop->longitude ?? '' }}">
                            
                            <p class="text-xs text-red-500 mt-2 font-medium">*Wajib: Geser dan klik peta untuk menentukan titik akurat bengkel Anda agar pelanggan bisa menemukan Anda.</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nomor WhatsApp Aktif * (Awali dengan 62...)</label>
                            <input type="number" name="nomor_kontak" 
                                value="{{ old('nomor_kontak', $workshop->nomor_kontak ?? '') }}" 
                                required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nama Kepala Bengkel (Opsional)</label>
                            <input type="text" name="nama_kepala_bengkel" 
                                value="{{ old('nama_kepala_bengkel', $workshop->nama_kepala_bengkel ?? '') }}" 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Foto Bengkel (Opsional)</label>
                            <input type="file" name="foto_bengkel" accept="image/*" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                        </div>
                    </div>

                    <div class="mt-8 flex justify-end">
                        <button type="submit" class="bg-indigo-600 text-white px-6 py-2.5 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 font-semibold transition">
                            Simpan Profil Bengkel
                        </button>
                    </div>
                </form>
            </div>
            
            <hr class="my-8 border-gray-300">
            <h3 class="text-2xl font-bold mb-6 text-gray-800">Pengaturan Akun & Keamanan</h3>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Jika bengkel sudah punya titik, arahkan ke titik itu. Jika belum, arahkan ke tengah peta (default: Jakarta)
            var startLat = {{ $workshop->latitude ?? '-6.200000' }};
            var startLng = {{ $workshop->longitude ?? '106.816666' }};
            var zoomLevel = {{ isset($workshop->latitude) ? '15' : '11' }};

            // Membangun peta
            var map = L.map('map').setView([startLat, startLng], zoomLevel);

            // Mengambil gambar peta dari OpenStreetMap
            L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
                maxZoom: 19,
                attribution: 'Tiles &copy; Esri &mdash; Source: Esri, i-cubed, USDA, USGS, AEX, GeoEye, Getmapping, Aerogrid, IGN, IGP, UPR-EAP, and the GIS User Community'
            }).addTo(map);

            var marker;

            // Jika sebelumnya sudah pernah disave, munculkan pin-nya
            @if(isset($workshop->latitude) && isset($workshop->longitude))
                marker = L.marker([startLat, startLng]).addTo(map);
            @endif

            // Jika peta diklik, pindahkan/buat pin baru dan isi nilai ke laci tersembunyi
            map.on('click', function(e) {
                var lat = e.latlng.lat;
                var lng = e.latlng.lng;

                // Memasukkan angka koordinat ke laci tersembunyi
                document.getElementById('latitude').value = lat;
                document.getElementById('longitude').value = lng;

                // Menancapkan pin
                if (marker) {
                    marker.setLatLng(e.latlng);
                } else {
                    marker = L.marker(e.latlng).addTo(map);
                }
            });
        });
    </script>
</x-app-layout>