<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class KategoriRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    public function rules(): array
    {
        // Ambil ID kategori dari route (untuk update)
        $kategoriId = $this->route('kategori')?->id;

        return [
            'nama_kategori' => [
                'required',
                'string',
                'max:100',
                Rule::unique('kategoris', 'nama_kategori')->ignore($kategoriId),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'nama_kategori.required' => 'Nama kategori wajib diisi.',
            'nama_kategori.unique'   => 'Nama kategori ini sudah ada.',
            'nama_kategori.max'      => 'Nama kategori maksimal 100 karakter.',
        ];
    }
}