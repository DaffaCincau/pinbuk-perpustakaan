<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PINBUK — Perpustakaan SMK Negeri 5 Surakarta</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-bg text-text-primary font-sans antialiased">

    {{-- NAVBAR --}}
    <header class="bg-white border-b border-border sticky top-0 z-50 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('images/logo-smk.png') }}" alt="Logo SMK" class="w-10 h-10 object-contain">
                    <div>
                        <h1 class="text-base font-bold text-text-primary leading-none">PINBUK</h1>
                        <p class="text-[10px] text-text-secondary mt-1">SMK Negeri 5 Surakarta</p>
                    </div>
                </div>

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

    {{-- HERO IMAGE --}}
    <section class="w-full h-[450px] md:h-[550px] bg-gray-900 relative border-b border-border overflow-hidden">
        <img src="https://www.smkn5surakarta.sch.id/wp-content/uploads/2023/02/smkn5solodepan.jpg" 
             alt="SMK Negeri 5 Surakarta" class="w-full h-full object-cover object-center opacity-100">
        <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/30 to-transparent"></div>
        <div class="absolute bottom-12 left-0 right-0 max-w-7xl mx-auto px-4 lg:px-8">
            <h2 class="text-4xl md:text-6xl font-bold text-white mb-3 drop-shadow-2xl">Selamat Datang di PINBUK</h2>
            <p class="text-gray-100 text-base md:text-xl max-w-2xl font-medium drop-shadow-lg">
                Sistem Informasi Peminjaman Buku Perpustakaan SMK Negeri 5 Surakarta.
            </p>
        </div>
    </section>

    {{-- MAIN CONTENT --}}
    <main class="max-w-7xl mx-auto px-4 lg:px-8 py-10 space-y-12">
        
        {{-- SECTION 1: JAM LAYANAN & INFO --}}
        <section class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="md:col-span-2 card card-pad shadow-sm flex flex-col justify-center bg-white">
                <h3 class="text-sm font-bold text-text-secondary uppercase tracking-wide mb-4">Jam Layanan Perpustakaan</h3>
                <div class="flex flex-wrap gap-4">
                    <div class="bg-bg border border-border text-text-primary rounded-lg px-8 py-4 min-w-[200px] shadow-sm">
                        <p class="text-xs text-text-secondary mb-1">Jam Buka</p>
                        <p class="text-3xl font-black text-black">07.00 WIB</p>
                    </div>
                    <div class="bg-bg border border-border text-text-primary rounded-lg px-8 py-4 min-w-[200px] shadow-sm">
                        <p class="text-xs text-text-secondary mb-1">Jam Tutup</p>
                        <p class="text-3xl font-black text-black">15.00 WIB</p>
                    </div>
                </div>
            </div>

            <div class="card card-pad shadow-sm bg-primary/5 border-primary/20 flex flex-col justify-center">
                <h3 class="text-sm font-bold text-primary mb-2">Layanan Mandiri</h3>
                <p class="text-sm text-text-secondary leading-relaxed">
                    Cari buku, cek ketersediaan stok, dan ajukan peminjaman secara online langsung dari mana saja. Cepat, mudah, dan transparan.
                </p>
            </div>
        </section>

        {{-- SECTION 2: REKOMENDASI BUKU --}}
        <section>
            <div class="flex items-center justify-between mb-6 border-b border-border pb-4">
                <div>
                    <h3 class="text-xl font-bold text-text-primary">Rekomendasi Bacaan</h3>
                    <p class="text-sm text-text-secondary mt-1">Jelajahi koleksi buku terbaru di perpustakaan kami.</p>
                </div>
                {{-- Tombol Lihat Semua diarahkan ke katalog publik --}}
                <a href="{{ route('guest.katalog') }}" class="btn-secondary btn-sm">Lihat Semua Katalog</a>
            </div>
            
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4">
                @forelse ($rekomendasiBuku as $buku)
                    <div class="bg-bg-card border border-border rounded-xl p-3 flex flex-col shadow-sm hover:border-primary/50 hover:shadow-md transition-all group">
                        <div class="aspect-[2/3] w-full rounded-md overflow-hidden bg-bg mb-3 border border-border relative">
                            <img src="{{ $buku->cover_url }}" alt="{{ $buku->judul }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            
                            {{-- Label Stok --}}
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
                            {{-- Tombol Detail diarahkan ke halaman publik --}}
                            <a href="{{ route('guest.buku.show', $buku) }}" class="border border-border text-text-secondary text-xs px-4 py-1.5 rounded hover:bg-primary hover:text-white hover:border-primary transition-colors font-medium shadow-sm w-full text-center">
                                Detail
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-10 text-center bg-bg-card border border-border rounded-xl">
                        <p class="text-text-secondary">Belum ada buku yang ditambahkan.</p>
                    </div>
                @endforelse
            </div>
        </section>

        {{-- SECTION 3: CTA --}}
        <section class="mt-16 pt-10 border-t border-border">
            <div class="bg-primary/5 border border-primary/20 rounded-2xl p-8 md:p-12 text-center relative overflow-hidden">
                <div class="relative z-10">
                    <h3 class="text-2xl md:text-3xl font-bold text-text-primary mb-4">Siap Menjelajahi Dunia Lewat Buku?</h3>
                    <p class="text-text-secondary mb-8 max-w-xl mx-auto">Bergabunglah dengan sistem perpustakaan digital kami. Temukan buku favoritmu, ajukan peminjaman, dan pantau statusnya langsung dari smartphone-mu.</p>
                    <a href="{{ route('register') }}" class="btn-primary btn-lg shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all">
                        Daftar Anggota Sekarang
                        <svg class="w-5 h-5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                    </a>
                </div>
            </div>
        </section>
    </main>

    {{-- FOOTER --}}
    <footer class="border-t border-border bg-white mt-12">
        <div class="max-w-7xl mx-auto px-4 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="md:col-span-2">
                    <div class="flex items-center gap-3 mb-4">
                        <img src="{{ asset('images/logo-smk.png') }}" alt="Logo SMK" class="w-8 h-8 object-contain">
                        <p class="text-lg font-bold text-text-primary">PINBUK</p>
                    </div>
                    <p class="text-sm text-text-secondary max-w-sm">
                        Sistem Informasi Peminjaman Buku Perpustakaan SMK Negeri 5 Surakarta. Membantu siswa mengakses literatur dengan lebih mudah dan cepat.
                    </p>
                </div>
                <div>
                    <h4 class="text-sm font-bold text-text-primary uppercase tracking-wide mb-4">Tautan Cepat</h4>
                    <ul class="space-y-2 text-sm text-text-secondary">
                        <li><a href="{{ route('guest.katalog') }}" class="hover:text-primary transition-colors">Katalog Buku</a></li>
                        <li><a href="{{ route('register') }}" class="hover:text-primary transition-colors">Pendaftaran Siswa</a></li>
                        <li><a href="{{ route('login') }}" class="hover:text-primary transition-colors">Login Petugas</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-sm font-bold text-text-primary uppercase tracking-wide mb-4">Kontak</h4>
                    <ul class="space-y-2 text-sm text-text-secondary">
                        <li class="flex items-start gap-2">
                            <svg class="w-4 h-4 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            Jl. Adi Sucipto No. 42, Surakarta
                        </li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-border mt-10 pt-6 flex flex-col md:flex-row items-center justify-between gap-4">
                <p class="text-xs text-text-muted">&copy; {{ date('Y') }} PINBUK — SMK Negeri 5 Surakarta. All rights reserved.</p>
                <p class="text-xs text-text-muted">Dibuat dengan ❤️ menggunakan Laravel & Tailwind CSS</p>
            </div>
        </div>
    </footer>
</body>
</html>