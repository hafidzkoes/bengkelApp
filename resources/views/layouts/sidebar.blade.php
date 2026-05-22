<div x-show="sidebarOpen" class="fixed inset-0 z-20 transition-opacity bg-black bg-opacity-50 lg:hidden" @click="sidebarOpen = false"></div>

<div :class="sidebarOpen ? 'translate-x-0 ease-out' : '-translate-x-full ease-in'" class="fixed inset-y-0 left-0 z-30 flex flex-col w-64 h-full overflow-y-auto transition duration-300 transform bg-slate-800 text-white lg:translate-x-0 lg:static lg:inset-0 shadow-xl border-r border-slate-700">
    
    <div class="flex items-center justify-center h-20 border-b border-slate-700 flex-shrink-0">
        <span class="text-xl font-bold text-white tracking-wider">
            Bengkel<span class="text-red-500">Owner</span>
        </span>
    </div>

    <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
        <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-4 block px-2">Daftar Menu</span>
        
        <a href="{{ route('dashboard') }}" 
           class="flex items-center px-4 py-3 text-sm font-semibold rounded-xl transition-colors {{ request()->routeIs('dashboard') ? 'bg-slate-700 text-white' : 'text-slate-300 hover:bg-slate-700 hover:text-white' }}">
            <svg class="w-5 h-5 text-orange-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            <span class="mx-3 font-semibold">Dashboard</span>
        </a>

        <a href="{{ route('owner.layanan') }}" 
           class="flex items-center px-4 py-3 text-sm font-semibold rounded-xl transition-colors {{ request()->routeIs('owner.layanan') ? 'bg-slate-700 text-white' : 'text-slate-300 hover:bg-slate-700 hover:text-white' }}">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-slate-400">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75a4.5 4.5 0 0 1-4.8 4.473l-3.32 3.32a.75.75 0 0 0-.22.53v2.25h-2.25a.75.75 0 0 0-.53.22l-1.47 1.47a.75.75 0 0 1-1.06 0l-3.22-3.22a.75.75 0 0 1 0-1.06l1.47-1.47a.75.75 0 0 0 .22-.53V10.5h2.25a.75.75 0 0 0 .53-.22l3.32-3.32a4.5 4.5 0 0 1 4.473-4.8c1.3.056 2.424.73 3.11 1.761a.75.75 0 0 1-.16 1.053l-2.237 1.677c-.42.315-.465.936-.1 1.3.364.365.985.32 1.3-.1l1.677-2.237a.75.75 0 0 1 1.053-.16c1.03.686 1.705 1.81 1.761 3.11Z" />
            </svg>
            <span class="mx-3 font-semibold">Layanan</span>
        </a>

        <a href="{{ route('owner.pembayaran') }}" 
           class="flex items-center px-4 py-3 text-sm font-semibold rounded-xl transition-colors {{ request()->routeIs('owner.pembayaran') ? 'bg-slate-700 text-white' : 'text-slate-300 hover:bg-slate-700 hover:text-white' }}">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-green-400">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.5 8.25h19m-19 6h19m-19-12h19c.621 0 1.125.504 1.125 1.125v15.75c0 .621-.504 1.125-1.125 1.125H2.5a1.125 1.125 0 0 1-1.125-1.125V3.375c0-.621.504-1.125 1.125-1.125Z" />
            </svg>
            <span class="mx-3 font-semibold">Status Pembayaran</span>
        </a>
    </nav>
</div>