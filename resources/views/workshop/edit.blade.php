<x-app-layout>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <div class="bg-white min-h-screen pt-6 pb-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-r-xl shadow-sm flex items-center gap-3">
                    <span class="text-xl">✅</span>
                    <span class="font-semibold">{{ session('success') }}</span>
                </div>
            @endif

            <div class="mb-8 border-b border-gray-200 pb-5">
                <h2 class="text-2xl font-extrabold text-gray-900 tracking-tight">Edit Profil Bengkel</h2>
                <p class="text-sm text-gray-500 mt-1">Silakan lengkapi data operasional bengkel Anda dan tentukan titik koordinat yang akurat.</p>
            </div>

            <form action="{{ route('workshop.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12">
                    
                    <div class="lg:col-span-5 space-y-8">
                        
                        <div class="bg-gray-50 p-5 rounded-2xl border border-gray-200">
                            <label class="flex items-center gap-2 text-sm font-bold text-gray-800 mb-3">
                                <span class="text-lg">📍</span> Titik Koordinat Bengkel
                            </label>
                            
                            <div id="map" style="height: 300px; z-index: 1;" class="w-full rounded-xl shadow-inner border border-gray-300"></div>
                            
                            <p class="text-xs text-gray-500 mt-3 font-medium leading-relaxed bg-white p-2.5 rounded-lg border border-gray-100">
                                <span class="text-red-500 font-bold">*Wajib:</span> Geser dan klik pada peta untuk menancapkan pin lokasi tepat di atas bengkel Anda.
                            </p>

                            <input type="hidden" name="latitude" id="latitude" value="{{ $workshop->latitude ?? '' }}">
                            <input type="hidden" name="longitude" id="longitude" value="{{ $workshop->longitude ?? '' }}">
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-800 mb-2">Upload Foto Bengkel</label>
                            <div class="mt-1 flex justify-center px-6 pt-6 pb-8 border-2 border-gray-300 border-dashed rounded-2xl hover:border-red-400 hover:bg-red-50 transition-colors duration-300 bg-gray-50 group relative">
                                <div class="space-y-2 text-center">
                                    <span class="text-4xl text-gray-400 group-hover:text-red-400 transition-colors">📸</span>
                                    <div class="flex text-sm text-gray-600 justify-center mt-2">
                                        <label for="foto_bengkel" class="relative cursor-pointer bg-white px-3 py-1.5 rounded-lg border border-gray-200 font-semibold text-red-600 hover:text-red-700 hover:bg-red-50 focus-within:outline-none focus-within:ring-2 focus-within:ring-red-500 shadow-sm transition">
                                            <span>Pilih File Foto</span>
                                            <input id="foto_bengkel" name="foto_bengkel" type="file" class="sr-only" accept="image/*">
                                        </label>
                                    </div>
                                    <p class="text-xs text-gray-500 font-medium">PNG, JPG up to 2MB (Opsional)</p>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="lg:col-span-7 space-y-6">
                        
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1.5">Nama Bengkel <span class="text-red-500">*</span></label>
                            <input type="text" name="nama_bengkel" value="{{ old('nama_bengkel', $workshop->nama_bengkel ?? '') }}" required 
                                class="block w-full rounded-xl border-gray-300 bg-gray-50 text-gray-900 focus:bg-white focus:border-red-500 focus:ring-red-500 sm:text-sm py-3 transition-colors shadow-sm"
                                placeholder="Contoh: Bengkel Motor Jaya">
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1.5">Alamat Lengkap <span class="text-red-500">*</span></label>
                            <textarea name="alamat_bengkel" rows="4" required 
                                class="block w-full rounded-xl border-gray-300 bg-gray-50 text-gray-900 focus:bg-white focus:border-red-500 focus:ring-red-500 sm:text-sm py-3 transition-colors shadow-sm"
                                placeholder="Masukkan nama jalan, RT/RW, kecamatan, dan patokan terdekat...">{{ old('alamat_bengkel', $workshop->alamat_bengkel ?? '') }}</textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1.5">Nomor Telepon / WhatsApp <span class="text-red-500">*</span></label>
                            <div class="relative rounded-xl shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm font-bold">+62</span>
                                </div>
                                <input type="number" name="nomor_kontak" value="{{ old('nomor_kontak', str_starts_with($workshop->nomor_kontak ?? '', '62') ? substr($workshop->nomor_kontak, 2) : ($workshop->nomor_kontak ?? '')) }}" required 
                                    class="block w-full pl-12 rounded-xl border-gray-300 bg-gray-50 text-gray-900 focus:bg-white focus:border-red-500 focus:ring-red-500 sm:text-sm py-3 transition-colors"
                                    placeholder="81234567890">
                            </div>
                            <p class="text-[11px] text-gray-500 mt-1.5">Gunakan nomor yang aktif dan terhubung dengan WhatsApp.</p>
                        </div>

                        <div class="pt-2">
                            <label class="block text-sm font-bold text-gray-700 mb-1.5">Nama Kepala Bengkel (Opsional)</label>
                            <input type="text" name="nama_kepala_bengkel" value="{{ old('nama_kepala_bengkel', $workshop->nama_kepala_bengkel ?? '') }}" 
                                class="block w-full rounded-xl border-gray-300 bg-gray-50 text-gray-900 focus:bg-white focus:border-red-500 focus:ring-red-500 sm:text-sm py-3 transition-colors shadow-sm"
                                placeholder="Nama penanggung jawab bengkel">
                        </div>

                    </div>
                </div>

                <div class="mt-12 pt-6 border-t border-gray-200 flex justify-end">
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-8 py-3.5 rounded-xl shadow-md hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 font-extrabold transition-all duration-300 transform hover:-translate-y-0.5">
                        Simpan Perubahan
                    </button>
                </div>

            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var startLat = {{ $workshop->latitude ?? '-7.816700' }};
            var startLng = {{ $workshop->longitude ?? '110.916700' }};
            var zoomLevel = {{ isset($workshop->latitude) ? '15' : '11' }};

            var map = L.map('map').setView([startLat, startLng], zoomLevel);

            L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
                maxZoom: 19,
                attribution: 'Tiles &copy; Esri'
            }).addTo(map);

            var marker;

            @if(isset($workshop->latitude) && isset($workshop->longitude))
                marker = L.marker([startLat, startLng]).addTo(map);
            @endif

            map.on('click', function(e) {
                var lat = e.latlng.lat;
                var lng = e.latlng.lng;

                document.getElementById('latitude').value = lat;
                document.getElementById('longitude').value = lng;

                if (marker) {
                    marker.setLatLng(e.latlng);
                } else {
                    marker = L.marker(e.latlng).addTo(map);
                }
            });
        });
    </script>
</x-app-layout>