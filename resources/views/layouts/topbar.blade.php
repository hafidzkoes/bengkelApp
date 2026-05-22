<header class="bg-white border-b border-gray-200 shadow-sm z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20">
            
            <div class="flex-shrink-0 flex items-center">
                <a href="{{ url('/') }}" class="text-2xl font-extrabold text-gray-900 tracking-tight">
                    Bengkel<span class="text-red-600">App</span>
                </a>
            </div>

            @if(!auth()->check() || auth()->user()->role === 'customer')
                <div class="flex-1 flex justify-center px-4 md:px-8">
                    <div class="w-full max-w-3xl relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-red-500 font-bold" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="text" class="block w-full pl-12 pr-4 py-2.5 md:py-3 border border-gray-300 rounded-full leading-5 bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 sm:text-sm transition-all shadow-sm" placeholder="Nama layanan, bengkel, atau kota">
                    </div>
                </div>
            @endif

            <div class="flex-shrink-0 flex items-center gap-4 ml-auto">
                
                @auth
                    <div class="hidden sm:flex sm:items-center sm:ms-6">
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
                                    <x-dropdown-link :href="route('workshop.show')">Profil Bengkel</x-dropdown-link>
                                    <x-dropdown-link :href="route('workshop.edit')">Edit Profil Bengkel</x-dropdown-link>
                                @elseif(auth()->user()->role === 'customer')
                                    <x-dropdown-link :href="route('profile.show')">Profil Pengguna</x-dropdown-link>
                                    <x-dropdown-link :href="route('profile.edit')">Edit Profil Pengguna</x-dropdown-link>
                                @endif

                                <hr class="my-1 border-gray-100">
                                
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link :href="route('logout')"
                                            onclick="event.preventDefault(); this.closest('form').submit();" class="text-red-600 font-semibold">
                                        {{ __('Log Out') }}
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="bg-[#0082D4] hover:bg-blue-600 text-white px-6 py-2.5 rounded text-sm font-semibold transition-colors shadow-sm">
                        Masuk/Daftar
                    </a>
                @endauth

            </div>
        </div>
    </div>
</header>