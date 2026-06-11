<x-app-layout>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <div class="bg-white min-h-screen">
        
        <div class="relative h-64 md:h-80 w-full overflow-hidden">
            @if($workshop->foto_bengkel)
                <img src="{{ asset('storage/' . $workshop->foto_bengkel) }}" class="w-full h-full object-cover" alt="{{ $workshop->nama_bengkel }}">
            @else
                <div class="w-full h-full bg-gradient-to-r from-gray-800 to-gray-900 flex items-center justify-center">
                    <span class="text-white text-4xl opacity-10 font-bold">BengkelApp</span>
                </div>
            @endif
            
            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/10 to-transparent"></div>

            <div class="absolute bottom-0 left-0 w-full p-6 md:p-10">
                <div class="max-w-7xl mx-auto">
                    <h1 class="text-3xl md:text-5xl font-extrabold text-white tracking-tight drop-shadow-sm">
                        {{ $workshop->nama_bengkel }}
                    </h1>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-6 md:px-10 py-10">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-start">
                
                <div class="lg:col-span-4 space-y-6 text-gray-800">
                    
                    <div>
                        <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Nama Kepala Bengkel</h3>
                        <p class="text-base font-semibold text-gray-900 mt-1">
                            {{ $workshop->nama_kepala_bengkel ?? '-' }}
                        </p>
                    </div>

                    <div>
                        <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Email Bengkel</h3>
                        <p class="text-base font-semibold text-gray-900 mt-1">
                            {{ $user->email }}
                        </p>
                    </div>

                    <div>
                        <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Nomor WhatsApp</h3>
                        <p class="text-base font-semibold text-gray-900 mt-1">
                            0{{ $workshop->nomor_kontak }}
                        </p>
                    </div>

                    <div>
                        <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Alamat Lengkap</h3>
                        <p class="text-sm text-gray-600 mt-1 leading-relaxed font-medium">
                            {{ $workshop->alamat_bengkel }}
                        </p>
                    </div>

                    <div>
                        <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Koordinat LBS</h3>
                        <code class="text-xs font-mono font-bold text-red-600 block mt-1 bg-gray-50 p-2 rounded-lg border border-gray-100 w-fit">
                            {{ $workshop->latitude }}, {{ $workshop->longitude }}
                        </code>
                    </div>

                </div>
                
                <div class="lg:col-span-8 shadow-sm rounded-2xl overflow-hidden border border-gray-200">
                    <div id="map-show" style="height: 380px;" class="w-full z-10"></div>
                </div>

            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var lat = {{ $workshop->latitude }};
            var lng = {{ $workshop->longitude }};

            var map = L.map('map-show', {
                dragging: true,
                zoomControl: true,
                scrollWheelZoom: false
            }).setView([lat, lng], 16);

            L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
                maxZoom: 19,
                attribution: 'Tiles &copy; Esri'
            }).addTo(map);

            L.marker([lat, lng]).addTo(map)
                .bindPopup("<b>{{ $workshop->nama_bengkel }}</b>")
                .openPopup();
        });
    </script>
</x-app-layout>