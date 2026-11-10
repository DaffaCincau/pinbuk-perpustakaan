@extends('layouts.admin')

@section('title', $buku->judul)
@section('page-title', 'Detail Buku')
@section('page-subtitle', $buku->judul)

@section('topbar-actions')
    <div class="flex gap-2">
        {{-- 👇 TOMBOL HAPUS ADA DI SINI 👇 --}}
        <form method="POST" action="{{ route('admin.bukus.destroy', $buku) }}" 
              onsubmit="return confirm('Yakin ingin menghapus buku {{ $buku->judul }} secara permanen?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn-danger btn-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
                Hapus
            </button>
        </form>
        {{-- 👆 SAMPAI SINI 👆 --}}

        <a href="{{ route('admin.bukus.edit', $buku) }}" class="btn-secondary btn-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
            </svg>
            Edit
        </a>

        <a href="{{ route('admin.bukus.index') }}" class="btn-ghost btn-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali
        </a>
    </div>
@endsection

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-[280px_1fr] gap-4">

    {{-- Cover --}}
    <div class="card card-pad shadow-sm">
        <div class="aspect-[2/3] rounded-lg overflow-hidden bg-bg border border-border">
            <img src="{{ $buku->cover_url }}"
                 alt="{{ $buku->judul }}"
                 class="w-full h-full object-cover">
        </div>
    </div>

    {{-- Detail --}}
    <div class="space-y-4">

        <div class="card card-pad shadow-sm">
            <span class="badge bg-primary/10 text-primary border-primary/30 mb-3">
                {{ $buku->kategori->nama_kategori ?? 'Tanpa Kategori' }}
            </span>
            <h1 class="text-2xl font-bold text-text-primary leading-tight">{{ $buku->judul }}</h1>

            <div class="grid grid-cols-2 gap-4 mt-5 pt-5 border-t border-border">
                <div>
                    <p class="text-xs text-text-muted uppercase tracking-wide">Kode Buku</p>
                    <p class="text-sm font-mono text-text-primary mt-1">{{ $buku->kode_buku }}</p>
                </div>
                <div>
                    <p class="text-xs text-text-muted uppercase tracking-wide">Tahun Terbit</p>
                    <p class="text-sm text-text-primary mt-1">{{ $buku->tahun_terbit }}</p>
                </div>
                <div>
                    <p class="text-xs text-text-muted uppercase tracking-wide">Pengarang</p>
                    <p class="text-sm text-text-primary mt-1">{{ $buku->pengarang }}</p>
                </div>
                <div>
                    <p class="text-xs text-text-muted uppercase tracking-wide">Penerbit</p>
                    <p class="text-sm text-text-primary mt-1">{{ $buku->penerbit }}</p>
                </div>
            </div>
        </div>

        {{-- Stok --}}
        <div class="grid grid-cols-3 gap-4">
            <div class="card card-pad shadow-sm">
                <p class="text-xs text-text-secondary uppercase tracking-wide">Stok Tersedia</p>
                <p class="text-2xl font-bold text-{{ $buku->stok > 0 ? 'success' : 'danger' }} mt-1">
                    {{ $buku->stok }}
                </p>
            </div>
            <div class="card card-pad shadow-sm">
                <p class="text-xs text-text-secondary uppercase tracking-wide">Sedang Dipinjam</p>
                <p class="text-2xl font-bold text-accent mt-1">{{ $buku->sedang_dipinjam }}</p>
            </div>
            <div class="card card-pad shadow-sm">
                <p class="text-xs text-text-secondary uppercase tracking-wide">Total Transaksi</p>
                <p class="text-2xl font-bold text-primary mt-1">{{ $buku->peminjamans->count() }}</p>
            </div>
        </div>

        {{-- Riwayat Peminjaman --}}
        <div class="card shadow-sm">
            <div class="px-5 py-4 border-b border-border">
                <h2 class="text-sm font-bold">Riwayat Peminjaman Buku Ini</h2>
            </div>

            @if ($buku->peminjamans->isEmpty())
                <div class="empty-state">
                    <p class="text-sm text-text-secondary">Belum ada riwayat peminjaman</p>
                </div>
            @else
                <div class="table-wrapper border-0 rounded-none">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Peminjam</th>
                                <th>Tanggal Pinjam</th>
                                <th>Tanggal Kembali</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($buku->peminjamans->sortByDesc('created_at')->take(10) as $p)
                                <tr>
                                    <td>
                                        <p class="text-sm">{{ $p->user->name }}</p>
                                        @if ($p->user->nis)
                                            <p class="text-[10px] text-text-muted">NIS: {{ $p->user->nis }}</p>
                                        @endif
                                    </td>
                                    <td class="text-sm">{{ $p->tanggal_pinjam->format('d M Y') }}</td>
                                    <td class="text-sm">{{ $p->tanggal_kembali->format('d M Y') }}</td>
                                    <td><x-status-badge :status="$p->status" /></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

    </div>
</div>
@endsection