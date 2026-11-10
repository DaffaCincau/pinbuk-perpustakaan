@extends('layouts.admin')

@section('title', 'Data Buku')
@section('page-title', 'Data Buku')
@section('page-subtitle', 'Kelola koleksi buku perpustakaan')

@section('topbar-actions')
    <a href="{{ route('admin.bukus.create') }}" class="btn-primary btn-sm">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
        </svg>
        Tambah Buku
    </a>
@endsection

@section('content')
<div class="space-y-4">

    {{-- Filter --}}
    <div class="card card-pad">
        <form method="GET" action="{{ route('admin.bukus.index') }}"
              class="grid grid-cols-1 md:grid-cols-[1fr_200px_auto_auto] gap-2">
            <input type="text"
                   name="q"
                   value="{{ $keyword }}"
                   placeholder="Cari judul, pengarang, penerbit, atau kode..."
                   class="input-field">

            <select name="kategori" class="input-field">
                <option value="">Semua Kategori</option>
                @foreach ($kategoris as $kat)
                    <option value="{{ $kat->id }}" @selected($kategoriId == $kat->id)>
                        {{ $kat->nama_kategori }}
                    </option>
                @endforeach
            </select>

            <button type="submit" class="btn-secondary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                Filter
            </button>

            @if ($keyword || $kategoriId)
                <a href="{{ route('admin.bukus.index') }}" class="btn-ghost">Reset</a>
            @endif
        </form>
    </div>

    {{-- Grid Buku --}}
    @if ($bukus->isEmpty())
        <div class="card">
            <div class="empty-state">
                <svg class="w-12 h-12 text-text-muted mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
                <p class="text-sm text-text-secondary">
                    @if ($keyword || $kategoriId)
                        Tidak ada buku yang cocok dengan filter
                    @else
                        Belum ada buku di perpustakaan
                    @endif
                </p>
                <a href="{{ route('admin.bukus.create') }}" class="btn-primary btn-sm mt-4">
                    Tambah Buku
                </a>
            </div>
        </div>
    @else
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4">
            @foreach ($bukus as $buku)
                <x-book-card :buku="$buku" />
            @endforeach
        </div>

        @if ($bukus->hasPages())
            <div class="card card-pad">
                {{ $bukus->links() }}
            </div>
        @endif
    @endif

</div>
@endsection