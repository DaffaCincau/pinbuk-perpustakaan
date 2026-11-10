@extends('layouts.siswa')

@section('title', 'Dashboard')
@section('page-title', 'Halo, ' . auth()->user()->name . ' 👋')
@section('page-subtitle', 'Selamat datang di PINBUK — Perpustakaan SMK Negeri 5 Surakarta')

@section('content')
<div class="space-y-6">

    {{-- ═══════════════════════════════════════ --}}
    {{-- STAT CARDS --}}
    {{-- ═══════════════════════════════════════ --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

        {{-- Sedang Dipinjam --}}
        <div class="card card-pad shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <div class="w-10 h-10 rounded-lg bg-bg border border-border flex items-center justify-center">
                    <svg class="w-5 h-5 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
            </div>
            <p class="text-text-secondary text-xs font-medium uppercase tracking-wide">Sedang Dipinjam</p>
            <p class="text-3xl font-bold text-text-primary mt-1">{{ $sedangDipinjam }}</p>
            <a href="{{ route('siswa.peminjamans.index', ['status' => 'dipinjam']) }}"
               class="text-xs text-text-muted hover:text-primary transition-colors mt-2 inline-block font-medium">
                Lihat detail &rarr;
            </a>
        </div>

        {{-- Menunggu Verifikasi --}}
        <div class="card card-pad shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <div class="w-10 h-10 rounded-lg bg-bg border border-border flex items-center justify-center">
                    <svg class="w-5 h-5 text-warning" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                @if ($pending > 0)
                    <span class="text-[10px] font-bold text-text-secondary uppercase">Perlu Aksi</span>
                @endif
            </div>
            <p class="text-text-secondary text-xs font-medium uppercase tracking-wide">Menunggu Verifikasi</p>
            <p class="text-3xl font-bold text-text-primary mt-1">{{ $pending }}</p>
            <a href="{{ route('siswa.peminjamans.index', ['status' => 'menunggu']) }}"
               class="text-xs text-text-muted hover:text-primary transition-colors mt-2 inline-block font-medium">
                Lihat pengajuan &rarr;
            </a>
        </div>

        {{-- Total Riwayat --}}
        <div class="card card-pad shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <div class="w-10 h-10 rounded-lg bg-bg border border-border flex items-center justify-center">
                    <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
            </div>
            <p class="text-text-secondary text-xs font-medium uppercase tracking-wide">Total Riwayat</p>
            <p class="text-3xl font-bold text-text-primary mt-1">{{ $totalRiwayat }}</p>
            <a href="{{ route('siswa.peminjamans.index') }}"
               class="text-xs text-text-muted hover:text-primary transition-colors mt-2 inline-block font-medium">
                Semua riwayat &rarr;
            </a>
        </div>
    </div>

    {{-- ═══════════════════════════════════════ --}}
    {{-- CTA CARI BUKU (Dibuat solid, tidak gradient) --}}
    {{-- ═══════════════════════════════════════ --}}
    <div class="card card-pad bg-white border-border shadow-sm">
        <div class="flex flex-col md:flex-row md:items-center gap-4">
            <div class="flex-1">
                <h2 class="text-base font-bold text-text-primary mb-1">Cari buku favoritmu 📚</h2>
                <p class="text-sm text-text-secondary">
                    Jelajahi koleksi perpustakaan dan ajukan peminjaman langsung dari sini.
                </p>
            </div>
            <a href="{{ route('siswa.katalog.index') }}" class="btn-primary shrink-0 shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                Jelajahi Katalog
            </a>
        </div>
    </div>

    {{-- ═══════════════════════════════════════ --}}
    {{-- PEMINJAMAN TERBARU --}}
    {{-- ═══════════════════════════════════════ --}}
    <div class="card shadow-sm">
        <div class="px-5 py-4 border-b border-border flex items-center justify-between">
            <div>
                <h2 class="text-sm font-bold text-text-primary">Aktivitas Terbaru</h2>
                <p class="text-xs text-text-muted mt-0.5">5 transaksi terakhir</p>
            </div>
            @if ($peminjamanTerbaru->isNotEmpty())
                <a href="{{ route('siswa.peminjamans.index') }}" class="text-xs text-primary hover:underline font-medium">
                    Lihat semua
                </a>
            @endif
        </div>

        @if ($peminjamanTerbaru->isEmpty())
            <div class="empty-state">
                <svg class="w-12 h-12 text-text-muted mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
                <p class="text-sm text-text-secondary">Belum ada aktivitas peminjaman</p>
                <p class="text-xs text-text-muted mt-1">Yuk mulai pinjam buku pertamamu!</p>
                <a href="{{ route('siswa.katalog.index') }}" class="btn-secondary btn-sm mt-4">
                    Jelajahi Katalog
                </a>
            </div>
        @else
            <div class="divide-y divide-border">
                @foreach ($peminjamanTerbaru as $p)
                    <a href="{{ route('siswa.peminjamans.index') }}"
                       class="flex items-center gap-4 px-5 py-4 hover:bg-bg transition-colors">
                        <div class="w-10 shrink-0">
                            <div class="aspect-[2/3] rounded overflow-hidden bg-bg border border-border">
                                <img src="{{ $p->buku->cover_url }}"
                                     alt="{{ $p->buku->judul }}"
                                     class="w-full h-full object-cover">
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-text-primary line-clamp-1">
                                {{ $p->buku->judul }}
                            </p>
                            <p class="text-[11px] text-text-muted mt-0.5">
                                Diajukan {{ $p->created_at->diffForHumans() }}
                            </p>
                        </div>
                        <x-status-badge :status="$p->status" />
                    </a>
                @endforeach
            </div>
        @endif
    </div>

</div>
@endsection