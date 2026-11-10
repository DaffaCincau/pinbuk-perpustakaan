@extends('layouts.admin')

@section('title', 'Edit Buku')
@section('page-title', 'Edit Buku')
@section('page-subtitle', 'Perbarui data buku')

@section('topbar-actions')
    <a href="{{ route('admin.bukus.index') }}" class="btn-ghost btn-sm">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Kembali
    </a>
@endsection

@section('content')
<form method="POST" action="{{ route('admin.bukus.update', $buku) }}"
      enctype="multipart/form-data"
      x-data="{
          coverPreview: null,
          handleCover(e) {
              const f = e.target.files[0];
              if (f) {
                  const reader = new FileReader();
                  reader.onload = (ev) => this.coverPreview = ev.target.result;
                  reader.readAsDataURL(f);
              }
          }
      }">
    @csrf
    @method('PUT')

    <div class="grid grid-cols-1 lg:grid-cols-[300px_1fr] gap-4">

        {{-- Cover --}}
        <div class="card card-pad">
            <p class="label-field">Cover Buku</p>

            <label for="cover"
                   class="block aspect-[2/3] rounded-lg border-2 border-dashed border-border
                          hover:border-primary/50 cursor-pointer overflow-hidden
                          transition-colors relative group">
                <template x-if="coverPreview">
                    <img :src="coverPreview" alt="Preview" class="w-full h-full object-cover">
                </template>
                <template x-if="!coverPreview">
                    <img src="{{ $buku->cover_url }}"
                         alt="{{ $buku->judul }}"
                         class="w-full h-full object-cover">
                </template>
                <div class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                    <div class="text-center">
                        <svg class="w-8 h-8 text-white mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <p class="text-xs text-white mt-1">Ganti Cover</p>
                    </div>
                </div>
            </label>
            <input type="file" id="cover" name="cover" accept="image/*" class="hidden" @change="handleCover($event)">

            <p class="helper-text">Biarkan kosong kalau tidak mau ganti cover.</p>
            @error('cover')<p class="error-text">{{ $message }}</p>@enderror
        </div>

        {{-- Form --}}
        <div class="card card-pad space-y-4">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="kode_buku" class="label-field">Kode Buku <span class="text-danger">*</span></label>
                    <input type="text" id="kode_buku" name="kode_buku"
                           value="{{ old('kode_buku', $buku->kode_buku) }}"
                           class="input-field @error('kode_buku') input-error @enderror">
                    @error('kode_buku')<p class="error-text">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="kategori_id" class="label-field">Kategori <span class="text-danger">*</span></label>
                    <select id="kategori_id" name="kategori_id"
                            class="input-field @error('kategori_id') input-error @enderror">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach ($kategoris as $kat)
                            <option value="{{ $kat->id }}" @selected(old('kategori_id', $buku->kategori_id) == $kat->id)>
                                {{ $kat->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                    @error('kategori_id')<p class="error-text">{{ $message }}</p>@enderror
                </div>
            </div>

            <div>
                <label for="judul" class="label-field">Judul Buku <span class="text-danger">*</span></label>
                <input type="text" id="judul" name="judul"
                       value="{{ old('judul', $buku->judul) }}"
                       class="input-field @error('judul') input-error @enderror">
                @error('judul')<p class="error-text">{{ $message }}</p>@enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="pengarang" class="label-field">Pengarang <span class="text-danger">*</span></label>
                    <input type="text" id="pengarang" name="pengarang"
                           value="{{ old('pengarang', $buku->pengarang) }}"
                           class="input-field @error('pengarang') input-error @enderror">
                    @error('pengarang')<p class="error-text">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="penerbit" class="label-field">Penerbit <span class="text-danger">*</span></label>
                    <input type="text" id="penerbit" name="penerbit"
                           value="{{ old('penerbit', $buku->penerbit) }}"
                           class="input-field @error('penerbit') input-error @enderror">
                    @error('penerbit')<p class="error-text">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="tahun_terbit" class="label-field">Tahun Terbit <span class="text-danger">*</span></label>
                    <input type="number" id="tahun_terbit" name="tahun_terbit"
                           value="{{ old('tahun_terbit', $buku->tahun_terbit) }}"
                           min="1900" max="{{ date('Y') + 1 }}"
                           class="input-field @error('tahun_terbit') input-error @enderror">
                    @error('tahun_terbit')<p class="error-text">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="stok" class="label-field">Stok <span class="text-danger">*</span></label>
                    <input type="number" id="stok" name="stok"
                           value="{{ old('stok', $buku->stok) }}"
                           min="0" max="9999"
                           class="input-field @error('stok') input-error @enderror">
                    @error('stok')<p class="error-text">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="alert alert-info">
                <svg class="w-4 h-4 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p class="text-xs">
                    Stok saat ini <strong>{{ $buku->stok }}</strong>.
                    Sedang dipinjam: <strong>{{ $buku->sedang_dipinjam }}</strong>.
                </p>
            </div>

            <div class="flex gap-2 pt-4 border-t border-border">
                <button type="submit" class="btn-primary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                    </svg>
                    Simpan Perubahan
                </button>
                <a href="{{ route('admin.bukus.index') }}" class="btn-ghost">Batal</a>
            </div>
        </div>
    </div>
</form>
@endsection