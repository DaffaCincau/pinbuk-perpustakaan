@extends('layouts.admin')

@section('title', 'Detail Peminjaman')
@section('page-title', 'Detail Peminjaman')
@section('page-subtitle', 'Kode: #' . str_pad($peminjaman->id, 5, '0', STR_PAD_LEFT))

@section('topbar-actions')
    <a href="{{ route('admin.peminjamans.index') }}" class="btn-ghost btn-sm">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Kembali
    </a>
@endsection

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-[1fr_320px] gap-4">

    {{-- LEFT COLUMN --}}
    <div class="space-y-4">
        {{-- Status Card --}}
        <div class="card card-pad shadow-sm">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <p class="text-xs text-text-muted uppercase tracking-wide mb-1.5">Status Saat Ini</p>
                    <x-status-badge :status="$peminjaman->status" class="text-sm py-1.5 px-3" />
                </div>
                @if ($peminjaman->hariTerlambat() > 0 && !$peminjaman->tanggal_dikembalikan)
                    <div class="text-right">
                        <p class="text-xs text-text-muted">Keterlambatan</p>
                        <p class="text-lg font-bold text-danger">{{ $peminjaman->hariTerlambat() }} hari</p>
                    </div>
                @endif
            </div>

            @if ($peminjaman->catatan)
                <div class="mt-4 pt-4 border-t border-border">
                    <p class="text-xs text-text-muted uppercase tracking-wide mb-1.5">Catatan Petugas</p>
                    <p class="text-sm text-text-primary bg-bg p-3 rounded-lg border border-border">{{ $peminjaman->catatan }}</p>
                </div>
            @endif
        </div>

        {{-- Buku Info --}}
        <div class="card card-pad shadow-sm">
            <p class="text-xs text-text-muted uppercase tracking-wide mb-3">Buku Dipinjam</p>
            <div class="flex gap-4">
                <div class="w-20 shrink-0">
                    <div class="aspect-[2/3] rounded-lg overflow-hidden bg-bg border border-border">
                        <img src="{{ $peminjaman->buku->cover_url }}" alt="{{ $peminjaman->buku->judul }}" class="w-full h-full object-cover">
                    </div>
                </div>
                <div class="flex-1 min-w-0">
                    <h3 class="text-base font-bold text-text-primary leading-snug">{{ $peminjaman->buku->judul }}</h3>
                    <p class="text-sm text-text-secondary mt-1">{{ $peminjaman->buku->pengarang }}</p>
                    <p class="text-xs text-text-muted mt-1">{{ $peminjaman->buku->penerbit }} • {{ $peminjaman->buku->tahun_terbit }}</p>
                    <p class="text-xs font-mono text-primary mt-2 bg-primary/10 inline-block px-2 py-0.5 rounded">{{ $peminjaman->buku->kode_buku }}</p>
                </div>
            </div>
        </div>

        {{-- Timeline --}}
        <div class="card card-pad shadow-sm">
            <p class="text-xs text-text-muted uppercase tracking-wide mb-4">Timeline Transaksi</p>
            <div class="space-y-4">
                <div class="flex gap-3">
                    <div class="w-8 h-8 rounded-full bg-bg border border-border flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4 text-text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium">Pengajuan dibuat</p>
                        <p class="text-xs text-text-muted">{{ $peminjaman->created_at->format('d M Y, H:i') }}</p>
                    </div>
                </div>
                <div class="flex gap-3">
                    <div class="w-8 h-8 rounded-full bg-bg border border-border flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4 text-text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium">Rencana Tanggal Pinjam</p>
                        <p class="text-xs text-text-muted">{{ $peminjaman->tanggal_pinjam->format('d M Y') }}</p>
                    </div>
                </div>
                <div class="flex gap-3">
                    <div class="w-8 h-8 rounded-full bg-bg border border-border flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4 text-text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium">Batas Kembali</p>
                        <p class="text-xs text-text-muted">{{ $peminjaman->tanggal_kembali->format('d M Y') }}</p>
                    </div>
                </div>
                @if ($peminjaman->tanggal_dikembalikan)
                    <div class="flex gap-3">
                        <div class="w-8 h-8 rounded-full bg-success/10 border border-success/30 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4 text-success" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium">Dikembalikan Pada</p>
                            <p class="text-xs text-text-muted">{{ $peminjaman->tanggal_dikembalikan->format('d M Y') }}</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- RIGHT COLUMN --}}
    <div class="space-y-4">
        {{-- Siswa Info --}}
        <div class="card card-pad shadow-sm">
            <p class="text-xs text-text-muted uppercase tracking-wide mb-3">Peminjam</p>
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-full bg-bg border border-border flex items-center justify-center text-sm font-bold text-text-secondary shrink-0">
                    {{ $peminjaman->user->initials() }}
                </div>
                <div class="min-w-0">
                    <p class="text-sm font-semibold truncate">{{ $peminjaman->user->name }}</p>
                    <p class="text-xs text-text-muted truncate">{{ $peminjaman->user->email }}</p>
                </div>
            </div>
            <div class="mt-4 pt-4 border-t border-border space-y-2">
                @if ($peminjaman->user->nis)
                    <div class="flex justify-between text-sm">
                        <span class="text-text-muted">NIS</span>
                        <span class="font-mono text-text-primary">{{ $peminjaman->user->nis }}</span>
                    </div>
                @endif
                @if ($peminjaman->user->phone)
                    <div class="flex justify-between text-sm">
                        <span class="text-text-muted">HP</span>
                        <span class="text-text-primary">{{ $peminjaman->user->phone }}</span>
                    </div>
                @endif
            </div>
        </div>

        {{-- Action Panel --}}
        <div class="card card-pad shadow-sm">
            <p class="text-xs text-text-muted uppercase tracking-wide mb-3">Aksi Petugas</p>

            {{-- TAHAP 1: MENUNGGU (Verifikasi / Tolak) --}}
            @if ($peminjaman->status === \App\Enums\StatusPeminjaman::MENUNGGU)
                <div class="space-y-3">
                    <form method="POST" action="{{ route('admin.peminjamans.terima', $peminjaman) }}">
                        @csrf
                        <div class="space-y-2">
                            <label class="label-field text-xs">Catatan (opsional)</label>
                            <textarea name="catatan" rows="2" placeholder="Pesan untuk siswa..." class="input-field text-xs"></textarea>
                        </div>
                        <button type="submit" class="btn-primary w-full mt-3 bg-success hover:bg-success/90 border-success">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                            Terima & Siapkan Buku
                        </button>
                    </form>
                    <div class="relative py-2">
                        <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-border"></div></div>
                        <div class="relative flex justify-center"><span class="bg-bg-card px-2 text-xs text-text-muted">atau</span></div>
                    </div>
                    <form method="POST" action="{{ route('admin.peminjamans.reject', $peminjaman) }}" onsubmit="return confirm('Yakin tolak pengajuan ini?')">
                        @csrf
                        <div class="space-y-2">
                            <label class="label-field text-xs">Alasan Penolakan <span class="text-danger">*</span></label>
                            <textarea name="catatan" rows="2" required placeholder="Contoh: Stok habis..." class="input-field text-xs"></textarea>
                        </div>
                        <button type="submit" class="btn-danger w-full mt-3">Tolak Pengajuan</button>
                    </form>
                </div>
            @endif

            {{-- TAHAP 2: DISETUJUI (Konfirmasi Ambil Buku) --}}
            @if ($peminjaman->status === \App\Enums\StatusPeminjaman::DISETUJUI)
                <div class="alert alert-info mb-4">
                    <svg class="w-5 h-5 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <div>
                        <p class="text-sm font-semibold">Buku Siap Diambil</p>
                        <p class="text-xs mt-1">Menunggu siswa datang ke perpustakaan.</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('admin.peminjamans.approve', $peminjaman) }}" onsubmit="return confirm('Konfirmasi bahwa siswa sudah mengambil buku ini?')">
                    @csrf
                    <button type="submit" class="btn-primary w-full">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Konfirmasi Siswa Ambil Buku
                    </button>
                </form>
            @endif

            {{-- TAHAP 3: DIPINJAM (Kembalikan) --}}
            @if ($peminjaman->isAktif())
                <div class="space-y-3">
                    @if ($peminjaman->hariTerlambat() > 0)
                        <div class="alert alert-warning">
                            <svg class="w-4 h-4 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M5.07 19h13.86c1.54 0 2.5-1.67 1.73-3L13.73 4c-.77-1.33-2.69-1.33-3.46 0L3.34 16c-.77 1.33.19 3 1.73 3z"/></svg>
                            <div class="text-xs">
                                <p class="font-semibold">Terlambat {{ $peminjaman->hariTerlambat() }} hari</p>
                                <p class="mt-0.5">Estimasi denda: <strong>Rp {{ number_format($peminjaman->hitungDenda(), 0, ',', '.') }}</strong></p>
                            </div>
                        </div>
                    @endif
                    <form method="POST" action="{{ route('admin.peminjamans.kembalikan', $peminjaman) }}" onsubmit="return confirm('Catat pengembalian buku ini?')">
                        @csrf
                        <button type="submit" class="btn-primary w-full">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 11l3 3L22 4"/><path stroke-linecap="round" stroke-linejoin="round" d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"/></svg>
                            Catat Pengembalian
                        </button>
                    </form>
                </div>
            @endif

            {{-- STATUS SELESAI / DITOLAK --}}
            @if (in_array($peminjaman->status, [\App\Enums\StatusPeminjaman::DIKEMBALIKAN, \App\Enums\StatusPeminjaman::DITOLAK]))
                <div class="text-center py-4 bg-bg rounded-lg border border-border">
                    <svg class="w-10 h-10 text-text-muted mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <p class="text-xs text-text-secondary">Transaksi Selesai</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection