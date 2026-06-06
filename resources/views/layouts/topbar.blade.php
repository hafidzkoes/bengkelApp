<header class="bg-white border-b border-gray-200 shadow-sm z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex flex-col md:flex-row md:items-center md:justify-between py-4 md:h-20 gap-3 md:gap-0">
            
            <div class="flex justify-between items-center w-full md:w-auto flex-shrink-0">
                
                <div class="hidden md:block w-32"></div>

                <div class="flex md:hidden items-center gap-3 ml-auto">
                    @auth
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center px-2 py-1.5 text-sm font-medium rounded-md text-gray-700 bg-white hover:text-gray-900 focus:outline-none transition">
                                    <svg class="w-6 h-6 text-blue-500 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="font-semibold max-w-[90px] truncate">{{ Auth::user()->name }}</span>
                                </button>
                            </x-slot>
                            <x-slot name="content">
                                @if(auth()->user()->role === 'owner')
                                    <x-dropdown-link :href="route('workshop.show')">
                                        {{ __('Profil Bengkel') }}
                                    </x-dropdown-link>
                                    <x-dropdown-link :href="route('workshop.edit')">
                                        {{ __('Edit Profil Bengkel') }}
                                    </x-dropdown-link>
                                @elseif(auth()->user()->role === 'customer')
                                    <x-dropdown-link :href="route('profile.show')">
                                        {{ __('Profil Pengguna') }}
                                    </x-dropdown-link>
                                @endif

                                <x-dropdown-link :href="route('profile.edit')">
                                    {{ __('Pengaturan Akun') }}
                                </x-dropdown-link>
                                
                                <hr class="my-1 border-gray-100">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="text-red-600 font-semibold">
                                        {{ __('Log Out') }}
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    @else
                        <a href="{{ route('register', ['role' => 'owner']) }}" class="text-red-600 hover:text-red-800 text-xs font-extrabold transition-colors">Daftar Mitra Bengkel</a>
                        <a href="{{ route('login') }}" class="bg-[#0082D4] hover:bg-blue-600 text-white px-4 py-2 rounded-xl text-xs font-bold transition shadow-sm">Masuk/Daftar</a>
                    @endauth
                </div>
            </div>

            @if(!auth()->check() || auth()->user()->role === 'customer')
                <div class="w-full md:flex-1 md:max-w-xl lg:max-w-2xl md:mx-8">
                    <form action="{{ route('cari.bengkel') }}" method="GET" class="w-full relative">
                        <input type="hidden" name="lat" id="topbar_lat" value="{{ request('lat') }}">
                        <input type="hidden" name="lng" id="topbar_lng" value="{{ request('lng') }}">
                        
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-red-500 font-bold" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="text" name="keyword" value="{{ request('keyword') }}" 
                               class="block w-full pl-11 pr-4 py-2.5 border border-gray-300 rounded-full leading-5 bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 text-sm transition shadow-sm" 
                               placeholder="Cari nama layanan, bengkel, atau kota...">
                    </form>
                </div>
            @else
                <div class="w-full md:flex-1 md:max-w-xl lg:max-w-2xl md:mx-8"></div>
            @endif

            <div class="hidden md:flex items-center gap-4 flex-shrink-0">
                @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:text-gray-900 focus:outline-none transition ease-in-out duration-150">
                                <svg class="w-7 h-7 text-blue-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="font-semibold">{{ Auth::user()->name }}</span>
                                <svg class="fill-current h-4 w-4 ml-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            @if(auth()->user()->role === 'owner')
                                <x-dropdown-link :href="route('workshop.show')">
                                    {{ __('Profil Bengkel') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('workshop.edit')">
                                    {{ __('Edit Profil Bengkel') }}
                                </x-dropdown-link>
                            @elseif(auth()->user()->role === 'customer')
                                <x-dropdown-link :href="route('profile.show')">
                                    {{ __('Profil Pengguna') }}
                                </x-dropdown-link>
                            @endif

                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Pengaturan Akun') }}
                            </x-dropdown-link>
                            
                            <hr class="my-1 border-gray-100">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="text-red-600 font-semibold">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <a href="{{ route('register', ['role' => 'owner']) }}" class="text-red-600 hover:text-red-800 text-sm font-extrabold transition-colors mr-2">Daftar Mitra Bengkel</a>
                    <a href="{{ route('login') }}" class="bg-[#0082D4] hover:bg-blue-600 text-white px-6 py-2.5 rounded text-sm font-semibold transition-colors shadow-sm">Masuk/Daftar</a>
                @endauth
            </div>

        </div>
    </div>
</header>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const topbarLat = document.getElementById('topbar_lat');
        const topbarLng = document.getElementById('topbar_lng');
        
        // Jika input tersedia tapi valuenya kosong, ambil dari localStorage HP pengguna
        if (topbarLat && topbarLng) {
            if (!topbarLat.value) topbarLat.value = localStorage.getItem('user_lat') || '';
            if (!topbarLng.value) topbarLng.value = localStorage.getItem('user_lng') || '';
        }
    });
</script>