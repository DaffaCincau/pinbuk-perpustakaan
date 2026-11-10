@extends('layouts.siswa')

@section('title', 'Peminjaman Saya')
@section('page-title', 'Peminjaman Saya')
@section('page-subtitle', 'Riwayat dan status semua pengajuan peminjamanmu')

@section('content')
<div class="space-y-4">

    {{-- ═══════════════════════════════════════ --}}
    {{-- STATUS TABS --}}
    {{-- ═══════════════════════════════════════ --}}
    <div class="card card-pad">
        <div class="flex flex-wrap gap-1.5">
            @php
                $tabs = [
                    ['value' => '',              'label' => 'Semua'],
                    ['value' => 'menunggu',      'label' => 'Menunggu'],
                    ['value' => 'dipinjam',      'label' => 'Dipinjam'],
                    ['value' => 'dikembalikan',  'label' => 'Dikembalikan'],
                    ['value' => 'terlambat',     'label' => 'Terlambat'],
                    ['value' => 'ditolak',       'label' => 'Ditolak'],
                ];
            @endphp

            @foreach ($tabs as $tab)
                <a href="{{ route('siswa.peminjamans.index', array_filter(['status' => $tab['value']])) }}"
                   class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium transition-colors
                          {{ request('status') === $tab['value'] || (request('status') === null && $tab['value'] === '')
                              ? 'bg-primary text-white'
                              : 'bg-bg-card text-text-secondary border border-border hover:border-border-light hover:text-text-primary' }}">
                    {{ $tab['label'] }}
                </a>
            @endforeach
        </div>
    </div>

    {{-- ═══════════════════════════════════════ --}}
    {{-- LIST PEMINJAMAN --}}
    {{-- ═══════════════════════════════════════ --}}
    @if ($peminjamans->isEmpty())
        <div class="card">
            <div class="empty-state">
                <svg class="w-14 h-14 text-text-muted mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
                <p class="text-base text-text-primary font-medium">
                    @if (request('status'))
                        Tidak ada peminjaman dengan status ini
                    @else
                        Belum ada riwayat peminjaman
                    @endif
                </p>
                <p class="text-sm text-text-secondary mt-1">
                    Mulai jelajahi katalog dan ajukan peminjaman buku pertamamu
                </p>
                <a href="{{ route('siswa.katalog.index') }}" class="btn-primary btn-sm mt-4">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                    Jelajahi Katalog
                </a>
            </div>
        </div>
    @else
        <div class="space-y-3">
            @foreach ($peminjamans as $p)
                <div class="card card-pad hover:border-border-light transition-colors">
                    <div class="flex gap-4">

                        {{-- Cover --}}
                        <a href="{{ route('siswa.katalog.show', $p->buku) }}"
                           class="w-16 sm:w-20 shrink-0">
                            <div class="aspect-[2/3] rounded-lg overflow-hidden bg-bg">
                                <img src="{{ $p->buku->cover_url }}"
                                     alt="{{ $p->buku->judul }}"
                                     class="w-full h-full object-cover">
                            </div>
                        </a>

                        {{-- Info --}}
                        <div class="flex-1 min-w-0">
                            <div class="flex items-start justify-between gap-3 flex-wrap">
                                <div class="min-w-0">
                                    <a href="{{ route('siswa.katalog.show', $p->buku) }}"
                                       class="text-sm sm:text-base font-semibold text-text-primary hover:text-primary transition-colors line-clamp-2">
                                        {{ $p->buku->judul }}
                                    </a>
                                    <p class="text-xs text-text-secondary mt-0.5">
                                        {{ $p->buku->pengarang }}
                                    </p>
                                </div>
                                <x-status-badge :status="$p->status" />
                            </div>

                            {{-- Dates --}}
                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 mt-3 text-xs">
                                <div>
                                    <p class="text-text-muted">Tgl. Pinjam</p>
                                    <p class="text-text-primary font-medium mt-0.5">
                                        {{ $p->tanggal_pinjam->format('d M Y') }}
                                    </p>
                                </div>
                                <div>
                                    <p class="text-text-muted">Batas Kembali</p>
                                    <p class="text-text-primary font-medium mt-0.5">
                                        {{ $p->tanggal_kembali->format('d M Y') }}
                                    </p>
                                </div>
                                @if ($p->tanggal_dikembalikan)
                                    <div>
                                        <p class="text-text-muted">Dikembalikan</p>
                                        <p class="text-success font-medium mt-0.5">
                                            {{ $p->tanggal_dikembalikan->format('d M Y') }}
                                        </p>
                                    </div>
                                @endif
                            </div>

                            {{-- Late indicator --}}
                            @if ($p->hariTerlambat() > 0 && !$p->tanggal_dikembalikan)
                                <div class="mt-3 p-2.5 rounded-lg bg-danger/10 border border-danger/30">
                                    <p class="text-xs text-danger font-medium flex items-center gap-1.5">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M5.07 19h13.86c1.54 0 2.5-1.67 1.73-3L13.73 4c-.77-1.33-2.69-1.33-3.46 0L3.34 16c-.77 1.33.19 3 1.73 3z"/>
                                        </svg>
                                        Terlambat {{ $p->hariTerlambat() }} hari —
                                        Estimasi denda: Rp {{ number_format($p->hitungDenda(), 0, ',', '.') }}
                                    </p>
                                </div>
                            @endif

                            {{-- Denda --}}
                            @if ($p->denda > 0 && $p->tanggal_dikembalikan)
                                <div class="mt-3 p-2.5 rounded-lg bg-warning/10 border border-warning/30">
                                    <p class="text-xs text-warning font-medium">
                                        Denda: Rp {{ number_format($p->denda, 0, ',', '.') }}
                                    </p>
                                </div>
                            @endif

                            {{-- Catatan dari admin --}}
                            @if ($p->catatan)
                                <div class="mt-3 p-2.5 rounded-lg bg-bg border border-border">
                                    <p class="text-[10px] text-text-muted uppercase tracking-wide font-semibold mb-1">
                                        Catatan Petugas
                                    </p>
                                    <p class="text-xs text-text-secondary">{{ $p->catatan }}</p>
                                </div>
                            @endif

                            {{-- Actions --}}
                            @if ($p->isPending())
                                <div class="mt-3 pt-3 border-t border-border flex justify-end">
                                    <form method="POST"
                                          action="{{ route('siswa.peminjamans.batal', $p) }}"
                                          onsubmit="return confirm('Yakin batalkan pengajuan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-ghost btn-sm text-danger hover:bg-danger/10">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                            Batalkan Pengajuan
                                        </button>
                                    </form>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @if ($peminjamans->hasPages())
            <div class="card card-pad">
                {{ $peminjamans->links() }}
            </div>
        @endif
    @endif

</div>
@endsection