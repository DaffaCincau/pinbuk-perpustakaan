<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BukuRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    public function rules(): array
    {
        $bukuId = $this->route('buku')?->id;

        return [
            'kode_buku'    => ['required', 'string', 'max:30', Rule::unique('bukus', 'kode_buku')->ignore($bukuId)],
            'judul'        => ['required', 'string', 'max:200'],
            'pengarang'    => ['required', 'string', 'max:150'],
            'penerbit'     => ['required', 'string', 'max:150'],
            'tahun_terbit' => ['required', 'integer', 'min:1900', 'max:' . (date('Y') + 1)],
            'stok'         => ['required', 'integer', 'min:0', 'max:9999'],
            'kategori_id'  => ['required', 'exists:kategoris,id'],
            'cover'        => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ];
    }

    public function messages(): array
    {
        return [
            'kode_buku.required'    => 'Kode buku wajib diisi.',
            'kode_buku.unique'      => 'Kode buku ini sudah dipakai.',
            'judul.required'        => 'Judul buku wajib diisi.',
            'pengarang.required'    => 'Nama pengarang wajib diisi.',
            'penerbit.required'     => 'Nama penerbit wajib diisi.',
            'tahun_terbit.required' => 'Tahun terbit wajib diisi.',
            'tahun_terbit.min'      => 'Tahun terbit tidak valid.',
            'tahun_terbit.max'      => 'Tahun terbit tidak valid.',
            'stok.required'         => 'Stok wajib diisi.',
            'stok.min'              => 'Stok tidak boleh negatif.',
            'kategori_id.required'  => 'Kategori wajib dipilih.',
            'kategori_id.exists'    => 'Kategori tidak ditemukan.',
            'cover.image'           => 'Cover harus berupa gambar.',
            'cover.mimes'           => 'Format cover harus JPG, PNG, atau WEBP.',
            'cover.max'             => 'Ukuran cover maksimal 2 MB.',
        ];
    }
}