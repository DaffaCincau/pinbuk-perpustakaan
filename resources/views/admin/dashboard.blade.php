@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Ringkasan aktivitas perpustakaan hari ini')

@section('content')
<div class="space-y-6">

    {{-- ═══════════════════════════════════════ --}}
    {{-- STAT CARDS (Gaya Minimalis Profesional) --}}
    {{-- ═══════════════════════════════════════ --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

        {{-- Total Buku --}}
        <div class="card card-pad shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <div class="w-10 h-10 rounded-lg bg-bg border border-border flex items-center justify-center">
                    <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
            </div>
            <p class="text-text-secondary text-xs font-medium uppercase tracking-wide">Total Buku</p>
            <p class="text-3xl font-bold text-text-primary mt-1">{{ number_format($totalBuku, 0, ',', '.') }}</p>
            <p class="text-xs text-text-muted mt-1">Stok total: {{ number_format($totalStok, 0, ',', '.') }}</p>
        </div>

        {{-- Pending --}}
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
            <a href="{{ route('admin.peminjamans.index', ['status' => 'menunggu']) }}"
               class="text-xs text-text-muted hover:text-primary transition-colors mt-2 inline-block font-medium">
                Lihat pengajuan &rarr;
            </a>
        </div>

        {{-- Sedang Dipinjam --}}
        <div class="card card-pad shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <div class="w-10 h-10 rounded-lg bg-bg border border-border flex items-center justify-center">
                    <svg class="w-5 h-5 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                    </svg>
                </div>
            </div>
            <p class="text-text-secondary text-xs font-medium uppercase tracking-wide">Sedang Dipinjam</p>
            <p class="text-3xl font-bold text-text-primary mt-1">{{ $sedangDipinjam }}</p>
            <p class="text-xs text-text-muted mt-2">Transaksi aktif</p>
        </div>

        {{-- Terlambat --}}
        <div class="card card-pad shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <div class="w-10 h-10 rounded-lg bg-bg border border-border flex items-center justify-center">
                    <svg class="w-5 h-5 text-danger" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M5.07 19h13.86c1.54 0 2.5-1.67 1.73-3L13.73 4c-.77-1.33-2.69-1.33-3.46 0L3.34 16c-.77 1.33.19 3 1.73 3z"/>
                    </svg>
                </div>
            </div>
            <p class="text-text-secondary text-xs font-medium uppercase tracking-wide">Terlambat</p>
            <p class="text-3xl font-bold text-text-primary mt-1">{{ $terlambat }}</p>
            <p class="text-xs text-text-muted mt-2">Perlu ditindak</p>
        </div>
    </div>

    {{-- ═══════════════════════════════════════ --}}
    {{-- QUICK ACTIONS (Solid & Clean) --}}
    {{-- ═══════════════════════════════════════ --}}
    <div class="card card-pad shadow-sm">
        <h2 class="text-sm font-bold text-text-primary mb-3">Aksi Cepat</h2>
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('admin.bukus.create') }}" class="btn-primary btn-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Buku
            </a>
            <a href="{{ route('admin.peminjamans.index', ['status' => 'menunggu']) }}" class="btn-secondary btn-sm">
                Verifikasi Peminjaman
            </a>
            <a href="{{ route('admin.kategoris.create') }}" class="btn-secondary btn-sm">
                Tambah Kategori
            </a>
        </div>
    </div>

    {{-- ═══════════════════════════════════════ --}}
    {{-- PEMINJAMAN TERBARU --}}
    {{-- ═══════════════════════════════════════ --}}
    <div class="card shadow-sm">
        <div class="px-5 py-4 border-b border-border flex items-center justify-between">
            <div>
                <h2 class="text-sm font-bold text-text-primary">Peminjaman Terbaru</h2>
                <p class="text-xs text-text-muted mt-0.5">8 transaksi terakhir</p>
            </div>
            <a href="{{ route('admin.peminjamans.index') }}" class="text-xs text-primary hover:underline font-medium">
                Lihat semua
            </a>
        </div>

        @if ($peminjamanTerbaru->isEmpty())
            <div class="empty-state">
                <svg class="w-12 h-12 text-text-muted mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
                <p class="text-sm text-text-secondary">Belum ada peminjaman</p>
            </div>
        @else
            <div class="table-wrapper border-0 rounded-none">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Siswa</th>
                            <th>Buku</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th class="text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($peminjamanTerbaru as $p)
                            <tr>
                                <td>
                                    <div class="flex items-center gap-2.5">
                                        <div class="w-8 h-8 rounded-full bg-bg border border-border flex items-center justify-center text-[10px] font-bold text-text-secondary shrink-0">
                                            {{ $p->user->initials() }}
                                        </div>
                                        <div class="min-w-0">
                                            <p class="text-sm font-medium truncate">{{ $p->user->name }}</p>
                                            @if ($p->user->nis)
                                                <p class="text-[10px] text-text-muted">NIS: {{ $p->user->nis }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <p class="text-sm line-clamp-1">{{ $p->buku->judul }}</p>
                                    <p class="text-[10px] text-text-muted">{{ $p->buku->kode_buku }}</p>
                                </td>
                                <td>
                                    <p class="text-xs text-text-primary">{{ $p->tanggal_pinjam->format('d M Y') }}</p>
                                    <p class="text-[10px] text-text-muted">s/d {{ $p->tanggal_kembali->format('d M Y') }}</p>
                                </td>
                                <td>
                                    <x-status-badge :status="$p->status" />
                                </td>
                                <td class="text-right">
                                    <a href="{{ route('admin.peminjamans.show', $p) }}"
                                       class="text-xs text-primary hover:underline font-medium">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

</div>
@endsection