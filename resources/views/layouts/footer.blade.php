<footer class="bg-slate-900 pt-12 pb-6 mt-auto">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
        
        <div class="flex flex-col md:flex-row justify-between items-start gap-8">
            
            <div class="flex flex-col md:w-1/2">
                <a href="{{ url('/') }}" class="text-2xl font-extrabold text-white tracking-tight mb-3 inline-block">
                    Bengkel<span class="text-red-600">App</span>
                </a>
                
                <p class="text-sm text-gray-400 max-w-sm leading-relaxed">
                    Jl. Contoh Alamat Pembuat Web No. 123, Kelurahan, Kecamatan, Kota, Provinsi 12345
                </p>
            </div>

            <div class="flex flex-col md:items-end w-full md:w-1/2 mt-8 md:mt-0">
                <div class="text-left"> 
                    <h3 class="text-white font-semibold text-lg mb-4">Hubungi Kami</h3>
                    <ul class="space-y-3 text-sm text-gray-400">
                        <li>
                            email@contoh.com
                        </li>
                    </ul>
                </div>
            </div>

        </div>

        <hr class="border-slate-700 my-8">

        <div class="text-center md:text-right text-sm text-gray-500 font-medium">
            &copy; {{ date('Y') }} BengkelApp. Semua hak cipta dilindungi.
        </div>
        
    </div>
</footer>