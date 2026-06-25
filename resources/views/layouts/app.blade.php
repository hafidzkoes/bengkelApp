<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'BengkelApp') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
    </head>
    <body class="font-sans antialiased text-gray-900">
        
        <div x-data="{ sidebarOpen: false }" class="flex h-screen bg-gray-50 overflow-hidden">

            @if(auth()->check() && auth()->user()->role === 'owner')
                @include('layouts.sidebar')
            @endif

            <div class="flex flex-col w-full flex-1 overflow-hidden">

                @include('layouts.topbar')

                <main class="flex-1 relative overflow-y-auto bg-gray-50 focus:outline-none">
                    <div class="w-full flex flex-col min-h-full">
                        {{ $slot }}
                    </div>
                </main>
                
            </div>
        </div>

    </body>
</html>