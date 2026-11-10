@extends('layouts.siswa')

@section('title', 'Ajukan Peminjaman')

@section('content')
<div class="space-y-6">

    <a href="{{ route('siswa.katalog.show', $buku) }}" class="btn-ghost btn-sm">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Kembali ke Detail Buku
    </a>

    <div>
        <h1 class="text-2xl font-bold text-text-primary">Ajukan Peminjaman</h1>
        <p class="text-sm text-text-secondary mt-1">
            Isi form di bawah, petugas akan memverifikasi pengajuanmu
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-[240px_1fr] gap-6">

        {{-- Buku Info --}}
        <div class="card card-pad">
            <p class="text-xs text-text-muted uppercase tracking-wide mb-3">Buku yang diajukan</p>
            <div class="aspect-[2/3] rounded-lg overflow-hidden bg-bg mb-3">
                <img src="{{ $buku->cover_url }}"
                     alt="{{ $buku->judul }}"
                     class="w-full h-full object-cover">
            </div>
            <h3 class="text-sm font-semibold text-text-primary line-clamp-3">{{ $buku->judul }}</h3>
            <p class="text-xs text-text-secondary mt-1">{{ $buku->pengarang }}</p>
            <p class="text-xs text-text-muted mt-0.5">{{ $buku->penerbit }} • {{ $buku->tahun_terbit }}</p>

            <div class="mt-3 pt-3 border-t border-border">
                <div class="flex items-center justify-between text-xs">
                    <span class="text-text-muted">Stok tersedia</span>
                    <span class="badge bg-success/10 text-success border-success/30">
                        {{ $buku->stok }} buku
                    </span>
                </div>
            </div>
        </div>

        {{-- Form --}}
        <div class="card card-pad">
            <form method="POST" action="{{ route('siswa.peminjamans.store') }}"
                  x-data="{
                      durasi: 7,
                      tanggal: '{{ old('tanggal_pinjam', date('Y-m-d')) }}',
                      get estimasiKembali() {
                          const d = new Date(this.tanggal);
                          d.setDate(d.getDate() + parseInt(this.durasi || 0));
                          return d.toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' });
                      }
                  }">
                @csrf
                <input type="hidden" name="buku_id" value="{{ $buku->id }}">

                <div class="space-y-5">

                    {{-- Tanggal Pinjam --}}
                    <div>
                        <label for="tanggal_pinjam" class="label-field">
                            Tanggal Pinjam <span class="text-danger">*</span>
                        </label>
                        <input type="date"
                               id="tanggal_pinjam"
                               name="tanggal_pinjam"
                               x-model="tanggal"
                               min="{{ date('Y-m-d') }}"
                               class="input-field @error('tanggal_pinjam') input-error @enderror">
                        @error('tanggal_pinjam')
                            <p class="error-text">{{ $message }}</p>
                        @enderror
                        <p class="helper-text">Pilih tanggal kapan kamu ingin meminjam buku ini.</p>
                    </div>

                    {{-- Durasi --}}
                    <div>
                        <label for="durasi" class="label-field">
                            Durasi Peminjaman <span class="text-danger">*</span>
                        </label>

                        {{-- Preset buttons --}}
                        <div class="flex flex-wrap gap-1.5 mb-3">
                            @foreach ([3, 7, 14, 21, 30] as $d)
                                <button type="button"
                                        @click="durasi = {{ $d }}"
                                        :class="durasi == {{ $d }}
                                            ? 'bg-primary text-white border-primary'
                                            : 'bg-bg-card text-text-secondary border-border hover:border-border-light hover:text-text-primary'"
                                        class="px-3 py-1.5 rounded-lg text-xs font-medium border transition-colors">
                                    {{ $d }} hari
                                </button>
                            @endforeach
                        </div>

                        <div class="relative">
                            <input type="number"
                                   id="durasi"
                                   name="durasi"
                                   x-model="durasi"
                                   min="1"
                                   max="30"
                                   class="input-field pr-16 @error('durasi') input-error @enderror">
                            <span class="absolute right-3.5 top-1/2 -translate-y-1/2 text-xs text-text-muted pointer-events-none">
                                hari
                            </span>
                        </div>
                        @error('durasi')
                            <p class="error-text">{{ $message }}</p>
                        @enderror
                        <p class="helper-text">Maksimal 30 hari. Denda keterlambatan Rp 1.000 per hari.</p>
                    </div>

                    {{-- Preview Estimasi --}}
                    <div class="p-4 rounded-lg bg-primary/5 border border-primary/20">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-primary shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <div class="text-sm">
                                <p class="text-text-secondary">Estimasi batas pengembalian:</p>
                                <p class="text-text-primary font-semibold mt-1" x-text="estimasiKembali"></p>
                            </div>
                        </div>
                    </div>

                    {{-- Submit --}}
                    <div class="flex flex-wrap gap-2 pt-4 border-t border-border">
                        <button type="submit" class="btn-primary">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                            </svg>
                            Kirim Pengajuan
                        </button>
                        <a href="{{ route('siswa.katalog.show', $buku) }}" class="btn-ghost">Batal</a>
                    </div>
                </div>
            </form>
        </div>

    </div>

</div>
@endsection