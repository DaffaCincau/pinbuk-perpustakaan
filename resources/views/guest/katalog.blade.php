<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Katalog Buku — PINBUK</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-bg text-text-primary font-sans antialiased">

    {{-- NAVBAR --}}
    <header class="bg-white border-b border-border sticky top-0 z-50 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <a href="{{ route('home') }}" class="flex items-center gap-3">
                    <img src="{{ asset('images/logo-smk.png') }}" alt="Logo SMK" class="w-10 h-10 object-contain">
                    <div>
                        <h1 class="text-base font-bold text-text-primary leading-none">PINBUK</h1>
                        <p class="text-[10px] text-text-secondary mt-1">SMK Negeri 5 Surakarta</p>
                    </div>
                </a>

                <div class="flex items-center gap-3">
                    @auth
                        <a href="{{ route('dashboard') }}" class="btn-primary shadow-md">Dashboard</a>
                    @else
                        <a href="{{ route('register') }}" class="border-2 border-primary text-primary px-5 py-2 rounded-lg text-sm font-bold hover:bg-primary hover:text-white transition-colors">Daftar</a>
                        <a href="{{ route('login') }}" class="bg-primary text-white px-6 py-2 rounded-lg text-sm font-bold shadow-md hover:bg-primary-600 transition-colors">Login</a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 lg:px-8 py-10">
        <div class="flex items-center justify-between mb-8 border-b border-border pb-4">
            <div>
                <h2 class="text-2xl font-bold text-text-primary">Semua Koleksi Buku</h2>
                <p class="text-sm text-text-secondary mt-1">Lihat seluruh katalog buku yang ada di perpustakaan.</p>
            </div>
            <a href="{{ route('home') }}" class="btn-secondary btn-sm">Kembali ke Beranda</a>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4">
            @forelse ($semuaBuku as $buku)
                <div class="bg-bg-card border border-border rounded-xl p-3 flex flex-col shadow-sm hover:border-primary/50 hover:shadow-md transition-all group">
                    <div class="aspect-[2/3] w-full rounded-md overflow-hidden bg-bg mb-3 border border-border relative">
                        <img src="{{ $buku->cover_url }}" alt="{{ $buku->judul }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        
                        <div class="absolute top-2 right-2">
                            @if ($buku->stok > 0)
                                <span class="bg-white/90 text-text-primary border border-border text-[10px] font-bold px-2 py-1 rounded shadow-sm">Stok: {{ $buku->stok }}</span>
                            @else
                                <span class="bg-danger text-white text-[10px] font-bold px-2 py-1 rounded shadow-sm">Habis</span>
                            @endif
                        </div>
                    </div>
                    <h4 class="text-sm font-bold text-text-primary text-center line-clamp-2 leading-tight">
                        {{ $buku->judul }}
                    </h4>
                    <p class="text-[10px] text-text-secondary text-center mt-1 mb-3 line-clamp-1">
                        {{ $buku->pengarang }}
                    </p>
                    <div class="mt-auto flex justify-center">
                        <a href="{{ route('guest.buku.show', $buku) }}" class="border border-border text-text-secondary text-xs px-4 py-1.5 rounded hover:bg-primary hover:text-white hover:border-primary transition-colors font-medium shadow-sm w-full text-center">
                            Detail
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-10 text-center bg-bg-card border border-border rounded-xl">
                    <p class="text-text-secondary">Belum ada buku.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-8">
            {{ $semuaBuku->links() }}
        </div>
    </main>

</body>
</html>