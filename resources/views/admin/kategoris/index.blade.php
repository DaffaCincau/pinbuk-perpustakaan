@extends('layouts.admin')

@section('title', 'Kategori Buku')
@section('page-title', 'Kategori Buku')
@section('page-subtitle', 'Kelola kategori untuk pengelompokan buku')

@section('topbar-actions')
    <a href="{{ route('admin.kategoris.create') }}" class="btn-primary btn-sm">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
        </svg>
        Tambah Kategori
    </a>
@endsection

@section('content')
<div class="space-y-4">

    {{-- Search --}}
    <div class="card card-pad">
        <form method="GET" action="{{ route('admin.kategoris.index') }}" class="flex gap-2">
            <input type="text"
                   name="q"
                   value="{{ $keyword }}"
                   placeholder="Cari kategori..."
                   class="input-field flex-1">
            <button type="submit" class="btn-secondary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                Cari
            </button>
            @if ($keyword)
                <a href="{{ route('admin.kategoris.index') }}" class="btn-ghost">Reset</a>
            @endif
        </form>
    </div>

    {{-- Table --}}
    <div class="card">
        @if ($kategoris->isEmpty())
            <div class="empty-state">
                <svg class="w-12 h-12 text-text-muted mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                </svg>
                <p class="text-sm text-text-secondary">Belum ada kategori</p>
                <p class="text-xs text-text-muted mt-1">Mulai dengan menambahkan kategori baru</p>
                <a href="{{ route('admin.kategoris.create') }}" class="btn-primary btn-sm mt-4">
                    Tambah Kategori
                </a>
            </div>
        @else
            <div class="table-wrapper border-0 rounded-none">
                <table class="table">
                    <thead>
                        <tr>
                            <th class="w-12">#</th>
                            <th>Nama Kategori</th>
                            <th class="w-32">Jumlah Buku</th>
                            <th class="w-32 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($kategoris as $i => $kategori)
                            <tr>
                                <td class="text-text-muted">{{ $kategoris->firstItem() + $i }}</td>
                                <td>
                                    <p class="font-medium">{{ $kategori->nama_kategori }}</p>
                                </td>
                                <td>
                                    <span class="badge bg-primary/10 text-primary border-primary/30">
                                        {{ $kategori->bukus_count }} buku
                                    </span>
                                </td>
                                <td class="text-right">
                                    <div class="inline-flex gap-1">
                                        <a href="{{ route('admin.kategoris.edit', $kategori) }}"
                                           class="btn-ghost btn-sm" title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                        </a>
                                        <form method="POST"
                                              action="{{ route('admin.kategoris.destroy', $kategori) }}"
                                              onsubmit="return confirm('Yakin hapus kategori {{ $kategori->nama_kategori }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-ghost btn-sm text-danger hover:bg-danger/10" title="Hapus">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if ($kategoris->hasPages())
                <div class="px-5 py-4 border-t border-border">
                    {{ $kategoris->links() }}
                </div>
            @endif
        @endif
    </div>

</div>
@endsection