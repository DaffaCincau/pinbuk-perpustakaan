@extends('layouts.siswa')

@section('title', 'Katalog Buku')
@section('page-title', 'Katalog Buku')
@section('page-subtitle', 'Cari dan ajukan peminjaman buku favoritmu')

@section('content')
<div class="space-y-6">

    {{-- ═══════════════════════════════════════ --}}
    {{-- SEARCH & FILTER --}}
    {{-- ═══════════════════════════════════════ --}}
    <div class="card card-pad">
        <form method="GET" action="{{ route('siswa.katalog.index') }}" class="space-y-4">

            {{-- Search bar --}}
            <div class="relative">
                <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-text-muted pointer-events-none"
                     fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input type="text"
                       name="q"
                       value="{{ $keyword }}"
                       placeholder="Cari judul, pengarang, atau penerbit..."
                       class="input-field pl-10">
            </div>

            {{-- Kategori chips --}}
            <div>
                <p class="text-xs text-text-muted mb-2 font-medium">Filter Kategori:</p>
                <div class="flex flex-wrap gap-1.5">
                    <a href="{{ route('siswa.katalog.index', array_filter(['q' => $keyword])) }}"
                       class="px-3 py-1.5 rounded-full text-xs font-medium transition-colors
                              {{ ! $kategoriId
                                  ? 'bg-primary text-white'
                                  : 'bg-bg-card text-text-secondary border border-border hover:border-border-light hover:text-text-primary' }}">
                        Semua
                    </a>
                    @foreach ($kategoris as $kat)
                        <a href="{{ route('siswa.katalog.index', array_filter(['q' => $keyword, 'kategori' => $kat->id])) }}"
                           class="px-3 py-1.5 rounded-full text-xs font-medium transition-colors
                                  {{ $kategoriId == $kat->id
                                      ? 'bg-primary text-white'
                                      : 'bg-bg-card text-text-secondary border border-border hover:border-border-light hover:text-text-primary' }}">
                            {{ $kat->nama_kategori }}
                        </a>
                    @endforeach
                </div>
            </div>

            {{-- Submit --}}
            <div class="flex gap-2">
                <button type="submit" class="btn-primary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    Cari
                </button>
                @if ($keyword || $kategoriId)
                    <a href="{{ route('siswa.katalog.index') }}" class="btn-ghost">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    {{-- ═══════════════════════════════════════ --}}
    {{-- HASIL --}}
    {{-- ═══════════════════════════════════════ --}}
    <div>
        <div class="flex items-center justify-between mb-4">
            <p class="text-sm text-text-secondary">
                @if ($keyword || $kategoriId)
                    Menampilkan <span class="text-text-primary font-semibold">{{ $bukus->total() }}</span> hasil
                    @if ($keyword)
                        untuk "<span class="text-primary">{{ $keyword }}</span>"
                    @endif
                @else
                    Total <span class="text-text-primary font-semibold">{{ $bukus->total() }}</span> buku tersedia
                @endif
            </p>
        </div>

        @if ($bukus->isEmpty())
            <div class="card">
                <div class="empty-state">
                    <svg class="w-14 h-14 text-text-muted mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <p class="text-base text-text-primary font-medium">Buku tidak ditemukan</p>
                    <p class="text-sm text-text-secondary mt-1">
                        Coba kata kunci lain atau ubah filter kategori
                    </p>
                    <a href="{{ route('siswa.katalog.index') }}" class="btn-secondary btn-sm mt-4">
                        Lihat semua buku
                    </a>
                </div>
            </div>
        @else
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
                @foreach ($bukus as $buku)
                    <x-book-card :buku="$buku" />
                @endforeach
            </div>

            @if ($bukus->hasPages())
                <div class="card card-pad mt-6">
                    {{ $bukus->links() }}
                </div>
            @endif
        @endif
    </div>

</div>
@endsection