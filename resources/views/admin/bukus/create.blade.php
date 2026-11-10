@extends('layouts.admin')

@section('title', 'Tambah Buku')
@section('page-title', 'Tambah Buku')
@section('page-subtitle', 'Tambahkan buku baru ke koleksi perpustakaan')

@section('topbar-actions')
    <a href="{{ route('admin.bukus.index') }}" class="btn-ghost btn-sm">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Kembali
    </a>
@endsection

@section('content')
<form method="POST" action="{{ route('admin.bukus.store') }}"
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

    <div class="grid grid-cols-1 lg:grid-cols-[300px_1fr] gap-4">

        {{-- Cover Upload --}}
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
                    <div class="w-full h-full flex flex-col items-center justify-center p-4 text-center">
                        <svg class="w-10 h-10 text-text-muted mb-2 group-hover:text-primary transition-colors"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <p class="text-xs text-text-secondary">Klik untuk upload</p>
                        <p class="text-[10px] text-text-muted mt-1">JPG, PNG, WEBP (max 2 MB)</p>
                    </div>
                </template>
            </label>
            <input type="file"
                   id="cover"
                   name="cover"
                   accept="image/*"
                   class="hidden"
                   @change="handleCover($event)">

            @error('cover')
                <p class="error-text">{{ $message }}</p>
            @enderror
        </div>

        {{-- Form Data --}}
        <div class="card card-pad space-y-4">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="kode_buku" class="label-field">Kode Buku <span class="text-danger">*</span></label>
                    <input type="text" id="kode_buku" name="kode_buku"
                           value="{{ old('kode_buku') }}"
                           placeholder="BK-001"
                           class="input-field @error('kode_buku') input-error @enderror" autofocus>
                    @error('kode_buku')<p class="error-text">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="kategori_id" class="label-field">Kategori <span class="text-danger">*</span></label>
                    <select id="kategori_id" name="kategori_id"
                            class="input-field @error('kategori_id') input-error @enderror">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach ($kategoris as $kat)
                            <option value="{{ $kat->id }}" @selected(old('kategori_id') == $kat->id)>
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
                       value="{{ old('judul') }}"
                       placeholder="Judul lengkap buku"
                       class="input-field @error('judul') input-error @enderror">
                @error('judul')<p class="error-text">{{ $message }}</p>@enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="pengarang" class="label-field">Pengarang <span class="text-danger">*</span></label>
                    <input type="text" id="pengarang" name="pengarang"
                           value="{{ old('pengarang') }}"
                           placeholder="Nama pengarang"
                           class="input-field @error('pengarang') input-error @enderror">
                    @error('pengarang')<p class="error-text">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="penerbit" class="label-field">Penerbit <span class="text-danger">*</span></label>
                    <input type="text" id="penerbit" name="penerbit"
                           value="{{ old('penerbit') }}"
                           placeholder="Nama penerbit"
                           class="input-field @error('penerbit') input-error @enderror">
                    @error('penerbit')<p class="error-text">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="tahun_terbit" class="label-field">Tahun Terbit <span class="text-danger">*</span></label>
                    <input type="number" id="tahun_terbit" name="tahun_terbit"
                           value="{{ old('tahun_terbit', date('Y')) }}"
                           min="1900" max="{{ date('Y') + 1 }}"
                           class="input-field @error('tahun_terbit') input-error @enderror">
                    @error('tahun_terbit')<p class="error-text">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="stok" class="label-field">Stok <span class="text-danger">*</span></label>
                    <input type="number" id="stok" name="stok"
                           value="{{ old('stok', 1) }}"
                           min="0" max="9999"
                           class="input-field @error('stok') input-error @enderror">
                    @error('stok')<p class="error-text">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="flex gap-2 pt-4 border-t border-border">
                <button type="submit" class="btn-primary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                    </svg>
                    Simpan Buku
                </button>
                <a href="{{ route('admin.bukus.index') }}" class="btn-ghost">Batal</a>
            </div>
        </div>
    </div>
</form>
@endsection