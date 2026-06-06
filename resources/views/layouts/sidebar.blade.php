<div x-show="sidebarOpen" class="fixed inset-0 z-20 transition-opacity bg-black/50 lg:hidden" @click="sidebarOpen = false"></div>

<!-- Mengubah bg-white menjadi bg-gray-50 agar sedikit lebih gelap/berbeda dari konten utama -->
<div :class="sidebarOpen ? 'translate-x-0 ease-out' : '-translate-x-full ease-in'" class="fixed inset-y-0 left-0 z-30 flex flex-col w-64 h-full overflow-y-auto transition duration-300 transform bg-gray-50 text-gray-800 lg:translate-x-0 lg:static lg:inset-0 shadow-sm border-r border-gray-200">
    
    <div class="flex items-center justify-center h-20 border-b border-gray-200 flex-shrink-0 bg-white">
        <span class="text-xl font-extrabold text-gray-900 tracking-tight">
            Bengkel<span class="text-red-600">Owner</span>
        </span>
    </div>

    <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
        <!-- Teks DAFTAR MENU diperkecil menjadi text-[10px] -->
        <span class="text-[10px] font-extrabold text-gray-400 uppercase tracking-widest mb-3 block px-3">Daftar Menu</span>
        
        <!-- Icon dihapus, teks otomatis lebih ke kiri -->
        <a href="{{ route('dashboard') }}" 
           class="block px-4 py-3 text-sm font-bold rounded-xl transition-all {{ request()->routeIs('dashboard') ? 'bg-red-50 text-red-600 shadow-sm' : 'text-gray-600 hover:bg-gray-100 hover:text-red-600' }}">
            Dashboard
        </a>

        <a href="{{ route('owner.layanan') }}" 
           class="block px-4 py-3 text-sm font-bold rounded-xl transition-all {{ request()->routeIs('owner.layanan') ? 'bg-red-50 text-red-600 shadow-sm' : 'text-gray-600 hover:bg-gray-100 hover:text-red-600' }}">
            Layanan
        </a>

        <a href="{{ route('owner.pembayaran') }}" 
           class="block px-4 py-3 text-sm font-bold rounded-xl transition-all {{ request()->routeIs('owner.pembayaran') ? 'bg-red-50 text-red-600 shadow-sm' : 'text-gray-600 hover:bg-gray-100 hover:text-red-600' }}">
            Status Pembayaran
        </a>
    </nav>
</div>