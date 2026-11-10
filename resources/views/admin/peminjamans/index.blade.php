@extends('layouts.admin')

@section('title', 'Peminjaman')
@section('page-title', 'Manajemen Peminjaman')
@section('page-subtitle', 'Verifikasi pengajuan & catat pengembalian buku')

@section('topbar-actions')
    <a href="{{ route('admin.peminjamans.export-excel', request()->only('status', 'q')) }}"
       class="btn-secondary btn-sm" title="Export ke Excel">
        <svg class="w-4 h-4 text-success" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
        </svg>
        Excel
    </a>
    <a href="{{ route('admin.peminjamans.export-pdf', request()->only('status', 'q')) }}"
       class="btn-secondary btn-sm" title="Export ke PDF">
        <svg class="w-4 h-4 text-danger" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
        </svg>
        PDF
    </a>
@endsection

@section('content')
<div class="space-y-4">

    {{-- Status Tabs (Gaya Bawah / Underline ala GitHub) --}}
    <div class="border-b border-border">
        <nav class="flex flex-wrap gap-6 -mb-px">
            @php
                $tabs = [
                    ['value' => '',              'label' => 'Semua',           'count' => $counts['semua']],
                    ['value' => 'menunggu',      'label' => 'Menunggu',        'count' => $counts['menunggu']],
                    ['value' => 'dipinjam',      'label' => 'Dipinjam',        'count' => $counts['dipinjam']],
                    ['value' => 'dikembalikan',  'label' => 'Dikembalikan',    'count' => $counts['dikembalikan']],
                    ['value' => 'terlambat',     'label' => 'Terlambat',       'count' => $counts['terlambat']],
                    ['value' => 'ditolak',       'label' => 'Ditolak',         'count' => $counts['ditolak']],
                ];
                $currentStatus = request('status', '');
            @endphp

            @foreach ($tabs as $tab)
                <a href="{{ route('admin.peminjamans.index', array_filter(['status' => $tab['value']])) }}"
                   class="flex items-center gap-2 pb-3 text-sm font-medium border-b-2 transition-colors
                          {{ $currentStatus === $tab['value']
                              ? 'border-primary text-primary'
                              : 'border-transparent text-text-secondary hover:text-text-primary hover:border-border-light' }}">
                    {{ $tab['label'] }}
                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold {{ $currentStatus === $tab['value'] ? 'bg-primary/10 text-primary' : 'bg-bg border border-border text-text-muted' }}">
                        {{ $tab['count'] }}
                    </span>
                </a>
            @endforeach
        </nav>
    </div>

    {{-- Search --}}
    <div class="card card-pad shadow-sm">
        <form method="GET" action="{{ route('admin.peminjamans.index') }}" class="flex flex-wrap gap-2">
            @if (request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
            @endif
            <input type="text"
                   name="q"
                   value="{{ $keyword }}"
                   placeholder="Cari nama siswa, NIS, judul buku, atau kode buku..."
                   class="input-field flex-1 min-w-[240px]">
            <button type="submit" class="btn-primary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                Cari
            </button>
            @if ($keyword)
                <a href="{{ route('admin.peminjamans.index', ['status' => request('status')]) }}" class="btn-ghost">Reset</a>
            @endif
        </form>
    </div>

    {{-- Table --}}
    <div class="card shadow-sm">
        @if ($peminjamans->isEmpty())
            <div class="empty-state">
                <svg class="w-12 h-12 text-text-muted mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
                <p class="text-sm text-text-secondary">Tidak ada data peminjaman</p>
            </div>
        @else
            <div class="table-wrapper border-0 rounded-none">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Siswa</th>
                            <th>Buku</th>
                            <th>Tanggal Pinjam</th>
                            <th>Batas Kembali</th>
                            <th>Status</th>
                            <th class="text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($peminjamans as $p)
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
                                <td class="text-sm">{{ $p->tanggal_pinjam->format('d M Y') }}</td>
                                <td>
                                    <p class="text-sm">{{ $p->tanggal_kembali->format('d M Y') }}</p>
                                    @if ($p->hariTerlambat() > 0 && !$p->tanggal_dikembalikan)
                                        <p class="text-[10px] text-danger font-bold">+{{ $p->hariTerlambat() }} hari</p>
                                    @endif
                                </td>
                                <td><x-status-badge :status="$p->status" /></td>
                                <td class="text-right">
                                    <a href="{{ route('admin.peminjamans.show', $p) }}" class="text-xs text-primary hover:underline font-medium">
                                        Detail &rarr;
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if ($peminjamans->hasPages())
                <div class="px-5 py-4 border-t border-border">
                    {{ $peminjamans->links() }}
                </div>
            @endif
        @endif
    </div>

</div>
@endsection