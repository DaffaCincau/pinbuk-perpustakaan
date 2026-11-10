<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') — {{ config('app.name', 'PINBUK') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-bg text-text-primary font-sans antialiased">

    <div x-data="{ sidebarOpen: false }" class="min-h-screen flex">

        {{-- SIDEBAR DESKTOP --}}
        <aside class="hidden lg:flex lg:flex-col lg:w-64 bg-bg-card border-r border-border fixed inset-y-0 left-0 z-30">
            <div class="flex items-center gap-3 h-16 px-5 border-b border-border">
                <img src="{{ asset('images/logo-smk.png') }}" alt="Logo SMK" class="w-8 h-8 object-contain">
                <div>
                    <p class="text-sm font-bold leading-none">PINBUK</p>
                    <p class="text-[10px] text-text-muted leading-none mt-1">Admin Panel</p>
                </div>
            </div>

            <nav class="flex-1 overflow-y-auto px-3 py-4 space-y-1">
                <p class="px-3 pt-2 pb-1.5 text-[10px] font-bold text-text-muted uppercase tracking-wider">Utama</p>
                <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'sidebar-link-active' : '' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    Dashboard
                </a>

                <p class="px-3 pt-4 pb-1.5 text-[10px] font-bold text-text-muted uppercase tracking-wider">Perpustakaan</p>
                <a href="{{ route('admin.bukus.index') }}" class="sidebar-link {{ request()->routeIs('admin.bukus.*') ? 'sidebar-link-active' : '' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    Buku
                </a>
                <a href="{{ route('admin.kategoris.index') }}" class="sidebar-link {{ request()->routeIs('admin.kategoris.*') ? 'sidebar-link-active' : '' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                    Kategori
                </a>
                <a href="{{ route('admin.peminjamans.index') }}" class="sidebar-link {{ request()->routeIs('admin.peminjamans.*') ? 'sidebar-link-active' : '' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                    Peminjaman
                </a>

                <p class="px-3 pt-4 pb-1.5 text-[10px] font-bold text-text-muted uppercase tracking-wider">Akun</p>
                <a href="{{ route('profile.edit') }}" class="sidebar-link {{ request()->routeIs('profile.*') ? 'sidebar-link-active' : '' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    Profil
                </a>
            </nav>

            <div class="border-t border-border p-3">
                <div class="flex items-center gap-3 p-2.5 rounded-lg bg-bg">
                    <div class="w-9 h-9 rounded-full bg-primary/15 border border-primary/30 flex items-center justify-center text-xs font-bold text-primary">{{ auth()->user()->initials() }}</div>
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-semibold text-text-primary truncate">{{ auth()->user()->name }}</p>
                        <p class="text-[10px] text-text-muted truncate">{{ auth()->user()->email }}</p>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="p-1.5 rounded-md hover:bg-danger/10 text-text-muted hover:text-danger transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        {{-- SIDEBAR MOBILE --}}
        <div x-show="sidebarOpen" x-transition.opacity @click="sidebarOpen = false" class="fixed inset-0 bg-black/60 z-40 lg:hidden" style="display: none;"></div>
        <aside x-show="sidebarOpen" x-transition:enter="transition-transform duration-200" x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transition-transform duration-150" x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full" class="fixed inset-y-0 left-0 z-50 w-64 bg-bg-card border-r border-border flex flex-col lg:hidden" style="display: none;">
            <div class="flex items-center justify-between h-16 px-5 border-b border-border">
                <div class="flex items-center gap-2.5">
                    <img src="{{ asset('images/logo-smk.png') }}" alt="Logo SMK" class="w-8 h-8 object-contain">
                    <p class="text-sm font-bold">PINBUK</p>
                </div>
                <button @click="sidebarOpen = false" class="p-1.5 rounded-md hover:bg-bg-hover"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg></button>
            </div>
            <nav class="flex-1 overflow-y-auto px-3 py-4 space-y-1">
                <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'sidebar-link-active' : '' }}">Dashboard</a>
                <a href="{{ route('admin.bukus.index') }}" class="sidebar-link {{ request()->routeIs('admin.bukus.*') ? 'sidebar-link-active' : '' }}">Buku</a>
                <a href="{{ route('admin.kategoris.index') }}" class="sidebar-link {{ request()->routeIs('admin.kategoris.*') ? 'sidebar-link-active' : '' }}">Kategori</a>
                <a href="{{ route('admin.peminjamans.index') }}" class="sidebar-link {{ request()->routeIs('admin.peminjamans.*') ? 'sidebar-link-active' : '' }}">Peminjaman</a>
                <a href="{{ route('profile.edit') }}" class="sidebar-link {{ request()->routeIs('profile.*') ? 'sidebar-link-active' : '' }}">Profil</a>
            </nav>
        </aside>

        {{-- MAIN CONTENT --}}
        <div class="flex-1 flex flex-col min-w-0 lg:ml-64">
            <header class="sticky top-0 z-20 h-16 flex items-center gap-4 px-4 lg:px-6 bg-bg/80 backdrop-blur-md border-b border-border">
                <button @click="sidebarOpen = true" class="lg:hidden p-2 rounded-lg hover:bg-bg-hover">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
                <div class="flex-1 min-w-0">
                    <h1 class="text-base font-semibold text-text-primary truncate">@yield('page-title', 'Dashboard')</h1>
                    @hasSection('page-subtitle')
                        <p class="text-xs text-text-muted truncate mt-0.5">@yield('page-subtitle')</p>
                    @endif
                </div>
                @hasSection('topbar-actions')
                    <div class="flex items-center gap-2">@yield('topbar-actions')</div>
                @endif
            </header>

            <main class="flex-1 p-4 lg:p-6">
                @if (session('success'))
                    <div class="mb-4 alert alert-success animate-fade-in"><p class="text-sm">{{ session('success') }}</p></div>
                @endif
                @if (session('error'))
                    <div class="mb-4 alert alert-error animate-fade-in"><p class="text-sm">{{ session('error') }}</p></div>
                @endif
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>