<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Masuk' }} — {{ config('app.name', 'PINBUK') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-bg text-text-primary font-sans antialiased overflow-hidden">

    <div class="flex min-h-screen">
        
        {{-- KIRI: FOTO & TULISAN (TANPA LOGO GAMBAR) --}}
        <div class="hidden lg:flex lg:w-1/2 relative bg-gray-900 items-center justify-center border-r border-border">
            {{-- Gambar Gedung Sekolah --}}
            <img src="https://www.smkn5surakarta.sch.id/wp-content/uploads/2023/02/smkn5solodepan.jpg" 
                 alt="SMK Negeri 5 Surakarta" class="absolute inset-0 w-full h-full object-cover opacity-50">
            
            {{-- Overlay Gelap --}}
            <div class="absolute inset-0 bg-black/40"></div>
            
            {{-- Teks di Tengah --}}
            <div class="relative z-10 text-center px-12">
                <h1 class="text-5xl lg:text-7xl font-black text-white mb-4 drop-shadow-2xl tracking-tight">PINBUK</h1>
                <p class="text-lg lg:text-xl text-gray-200 max-w-md mx-auto leading-relaxed drop-shadow-md font-medium">
                    Sistem Informasi Peminjaman Buku Perpustakaan SMK Negeri 5 Surakarta.
                </p>
            </div>
        </div>

        {{-- KANAN: FORM LOGIN / REGISTER --}}
        <div class="w-full lg:w-1/2 flex items-center justify-center p-6 sm:p-12 bg-bg">
            <div class="w-full max-w-md">
                
                {{-- LOGO SMK DI MOBILE (Karena di desktop foto disembunyikan) --}}
                <div class="lg:hidden text-center mb-8">
                    <a href="/" class="inline-flex flex-col items-center gap-2">
                        <img src="{{ asset('images/logo-smk.png') }}" alt="Logo SMK" class="w-16 h-16 object-contain">
                        <h1 class="text-xl font-bold text-text-primary">PINBUK</h1>
                    </a>
                </div>

                {{-- Kotak Form --}}
                <div class="bg-bg-card border border-border rounded-2xl p-6 sm:p-8 shadow-sm">
                    {{ $slot }}
                </div>
                
                {{-- Footer Text --}}
                <p class="text-center text-xs text-text-muted mt-8">
                    &copy; {{ date('Y') }} PINBUK — SMK Negeri 5 Surakarta
                </p>
            </div>
        </div>
    </div>
</body>
</html>