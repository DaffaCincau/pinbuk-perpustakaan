@extends('layouts.siswa')

@section('title', $buku->judul)

@section('content')
<div class="space-y-6">

    {{-- Back button --}}
    <a href="{{ url()->previous() }}" class="btn-ghost btn-sm">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Kembali
    </a>

    {{-- Detail --}}
    <div class="grid grid-cols-1 md:grid-cols-[280px_1fr] gap-6">

        {{-- Cover --}}
        <div class="card card-pad shadow-sm bg-white">
            <div class="aspect-[2/3] rounded-lg overflow-hidden bg-bg border border-border">
                <img src="{{ $buku->cover_url }}"
                     alt="{{ $buku->judul }}"
                     class="w-full h-full object-cover">
            </div>

            {{-- Stok indicator --}}
            <div class="mt-4 p-3 rounded-lg {{ $buku->stok > 0 ? 'bg-success/10 border border-success/30' : 'bg-danger/10 border border-danger/30' }}">
                <div class="flex items-center gap-2">
                    <div class="w-2 h-2 rounded-full {{ $buku->stok > 0 ? 'bg-success' : 'bg-danger' }}"></div>
                    <p class="text-sm font-semibold {{ $buku->stok > 0 ? 'text-success' : 'text-danger' }}">
                        @if ($buku->stok > 0)
                            Tersedia — {{ $buku->stok }} buku
                        @else
                            Stok Habis
                        @endif
                    </p>
                </div>
            </div>
        </div>

        {{-- Info --}}
        <div class="space-y-4">

            <div class="card card-pad shadow-sm bg-white">
                <span class="badge bg-primary/10 text-primary border-primary/30 mb-3">
                    {{ $buku->kategori->nama_kategori ?? 'Tanpa Kategori' }}
                </span>

                <h1 class="text-2xl md:text-3xl font-bold text-text-primary leading-tight">
                    {{ $buku->judul }}
                </h1>
                <p class="text-xs font-mono text-text-muted mt-2">{{ $buku->kode_buku }}</p>

                <div class="grid grid-cols-2 gap-4 mt-6 pt-6 border-t border-border">
                    <div>
                        <p class="text-xs text-text-muted uppercase tracking-wide">Pengarang</p>
                        <p class="text-sm font-medium text-text-primary mt-1">{{ $buku->pengarang }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-text-muted uppercase tracking-wide">Penerbit</p>
                        <p class="text-sm font-medium text-text-primary mt-1">{{ $buku->penerbit }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-text-muted uppercase tracking-wide">Tahun Terbit</p>
                        <p class="text-sm font-medium text-text-primary mt-1">{{ $buku->tahun_terbit }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-text-muted uppercase tracking-wide">Kategori</p>
                        <p class="text-sm font-medium text-text-primary mt-1">
                            {{ $buku->kategori->nama_kategori ?? '-' }}
                        </p>
                    </div>
                </div>
            </div>

            {{-- CTA --}}
            <div class="card card-pad shadow-sm bg-white">
                
                {{-- KONDISI 1: JIKA YANG BUKA ADALAH TAMU (BELUM LOGIN) --}}
                @if (isset($isGuest) && $isGuest)
                    <div class="alert alert-info mb-4">
                        <svg class="w-5 h-5 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <div>
                            <p class="text-sm font-semibold">Ingin meminjam buku ini?</p>
                            <p class="text-xs mt-0.5">Anda harus masuk ke akun Siswa terlebih dahulu.</p>
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <a href="{{ route('login') }}" class="btn-primary w-full">Login Siswa</a>
                        <a href="{{ route('register') }}" class="btn-secondary w-full">Daftar Akun</a>
                    </div>

                {{-- KONDISI 2: JIKA SISWA SUDAH LOGIN --}}
                @else
                    @if ($sedangDipinjam)
                        <div class="alert alert-info">
                            <svg class="w-5 h-5 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <div>
                                <p class="text-sm font-semibold">Kamu sudah mengajukan / meminjam buku ini</p>
                                <p class="text-xs mt-0.5">Cek status di halaman Peminjaman Saya</p>
                            </div>
                        </div>
                        <a href="{{ route('siswa.peminjamans.index') }}" class="btn-secondary w-full mt-3">
                            Lihat Status Peminjaman
                        </a>
                    @elseif ($buku->stok > 0)
                        <h3 class="text-sm font-semibold text-text-primary mb-2">Tertarik meminjam buku ini?</h3>
                        <p class="text-xs text-text-secondary mb-4">Ajukan peminjaman sekarang, petugas akan memverifikasi dalam waktu singkat.</p>
                        <a href="{{ route('siswa.peminjamans.create', $buku) }}" class="btn-primary w-full">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                            </svg>
                            Ajukan Peminjaman
                        </a>
                    @else
                        <div class="alert alert-error">
                            <svg class="w-5 h-5 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <div>
                                <p class="text-sm font-semibold">Stok sedang habis</p>
                                <p class="text-xs mt-0.5">Coba lagi nanti atau cari buku lain</p>
                            </div>
                        </div>
                        <a href="{{ route('siswa.katalog.index') }}" class="btn-secondary w-full mt-3">
                            Cari Buku Lain
                        </a>
                    @endif
                @endif
            </div>

        </div>
    </div>
</div>
@endsection