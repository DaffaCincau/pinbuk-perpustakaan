<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Siswa') — {{ config('app.name', 'PINBUK') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-bg text-text-primary font-sans antialiased">

    <header x-data="{ mobileMenu: false, userMenu: false }" class="sticky top-0 z-30 bg-bg/80 backdrop-blur-md border-b border-border">
        <div class="max-w-7xl mx-auto px-4 lg:px-6">
            <div class="h-16 flex items-center gap-6">

                <a href="{{ route('siswa.dashboard') }}" class="flex items-center gap-2.5 shrink-0">
                    <img src="{{ asset('images/logo-smk.png') }}" alt="Logo SMK" class="w-8 h-8 object-contain">
                    <div class="hidden sm:block">
                        <p class="text-sm font-bold leading-none">PINBUK</p>
                        <p class="text-[10px] text-text-muted leading-none mt-1">Perpustakaan SMKN 5 Surakarta</p>
                    </div>
                </a>

                <nav class="hidden md:flex items-center gap-1 flex-1">
                    <a href="{{ route('siswa.dashboard') }}" class="px-3 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('siswa.dashboard') ? 'bg-primary/10 text-primary' : 'text-text-secondary hover:text-text-primary hover:bg-bg-hover' }}">Dashboard</a>
                    <a href="{{ route('siswa.katalog.index') }}" class="px-3 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('siswa.katalog.*') ? 'bg-primary/10 text-primary' : 'text-text-secondary hover:text-text-primary hover:bg-bg-hover' }}">Katalog Buku</a>
                    <a href="{{ route('siswa.peminjamans.index') }}" class="px-3 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('siswa.peminjamans.*') ? 'bg-primary/10 text-primary' : 'text-text-secondary hover:text-text-primary hover:bg-bg-hover' }}">Peminjaman Saya</a>
                </nav>

                <div class="hidden md:block flex-1"></div>

                <div class="relative ml-auto md:ml-0">
                    <button @click="userMenu = !userMenu" class="flex items-center gap-2.5 p-1.5 pr-3 rounded-full hover:bg-bg-hover transition-colors">
                        <div class="w-8 h-8 rounded-full bg-primary/15 border border-primary/30 flex items-center justify-center text-xs font-bold text-primary">
                            {{ auth()->user()->initials() }}
                        </div>
                        <span class="hidden sm:block text-sm font-medium">{{ auth()->user()->name }}</span>
                        <svg class="hidden sm:block w-3.5 h-3.5 text-text-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                    </button>

                    <div x-show="userMenu" x-transition @click.away="userMenu = false" class="absolute right-0 mt-2 w-56 rounded-xl bg-bg-card border border-border shadow-xl overflow-hidden z-40" style="display: none;">
                        <div class="px-4 py-3 border-b border-border">
                            <p class="text-sm font-semibold truncate">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-text-muted truncate">{{ auth()->user()->email }}</p>
                        </div>
                        <div class="p-1.5">
                            <a href="{{ route('profile.edit') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm text-text-secondary hover:bg-bg-hover hover:text-text-primary transition-colors">Profil Saya</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm text-text-secondary hover:bg-danger/10 hover:text-danger transition-colors">Logout</button>
                            </form>
                        </div>
                    </div>
                </div>

                <button @click="mobileMenu = !mobileMenu" class="md:hidden p-2 rounded-lg hover:bg-bg-hover">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
            </div>

            <div x-show="mobileMenu" x-transition class="md:hidden border-t border-border py-3 space-y-1" style="display: none;">
                <a href="{{ route('siswa.dashboard') }}" class="block px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('siswa.dashboard') ? 'bg-primary/10 text-primary' : 'text-text-secondary hover:bg-bg-hover' }}">Dashboard</a>
                <a href="{{ route('siswa.katalog.index') }}" class="block px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('siswa.katalog.*') ? 'bg-primary/10 text-primary' : 'text-text-secondary hover:bg-bg-hover' }}">Katalog Buku</a>
                <a href="{{ route('siswa.peminjamans.index') }}" class="block px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('siswa.peminjamans.*') ? 'bg-primary/10 text-primary' : 'text-text-secondary hover:bg-bg-hover' }}">Peminjaman Saya</a>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 lg:px-6 py-6 lg:py-8">
        @hasSection('page-title')
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-text-primary">@yield('page-title')</h1>
                @hasSection('page-subtitle')
                    <p class="text-sm text-text-secondary mt-1">@yield('page-subtitle')</p>
                @endif
            </div>
        @endif

        @if (session('success'))
            <div class="mb-4 alert alert-success animate-fade-in"><p class="text-sm">{{ session('success') }}</p></div>
        @endif
        @if (session('error'))
            <div class="mb-4 alert alert-error animate-fade-in"><p class="text-sm">{{ session('error') }}</p></div>
        @endif

        @yield('content')
    </main>

    <footer class="border-t border-border mt-16">
        <div class="max-w-7xl mx-auto px-4 lg:px-6 py-6 flex flex-col sm:flex-row items-center justify-between gap-2">
            <p class="text-xs text-text-muted">&copy; {{ date('Y') }} PINBUK — Perpustakaan SMK Negeri 5 Surakarta</p>
        </div>
    </footer>
</body>
</html>