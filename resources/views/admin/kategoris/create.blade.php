@extends('layouts.admin')

@section('title', 'Tambah Kategori')
@section('page-title', 'Tambah Kategori')
@section('page-subtitle', 'Buat kategori baru untuk pengelompokan buku')

@section('topbar-actions')
    <a href="{{ route('admin.kategoris.index') }}" class="btn-ghost btn-sm">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Kembali
    </a>
@endsection

@section('content')
<div class="max-w-2xl">

    <div class="card card-pad">
        <form method="POST" action="{{ route('admin.kategoris.store') }}">
            @csrf

            <div class="space-y-4">
                <div>
                    <label for="nama_kategori" class="label-field">
                        Nama Kategori <span class="text-danger">*</span>
                    </label>
                    <input type="text"
                           id="nama_kategori"
                           name="nama_kategori"
                           value="{{ old('nama_kategori') }}"
                           placeholder="Misal: Fiksi, Non-Fiksi, Pelajaran"
                           class="input-field @error('nama_kategori') input-error @enderror"
                           autofocus>
                    @error('nama_kategori')
                        <p class="error-text">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex gap-2 mt-6 pt-6 border-t border-border">
                <button type="submit" class="btn-primary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                    </svg>
                    Simpan Kategori
                </button>
                <a href="{{ route('admin.kategoris.index') }}" class="btn-ghost">Batal</a>
            </div>
        </form>
    </div>

</div>
@endsection