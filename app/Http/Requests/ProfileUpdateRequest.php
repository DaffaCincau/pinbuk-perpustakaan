<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        $userId = $this->user()->id;

        $rules = [
            'name'  => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($userId),
            ],
        ];

        // NIS & phone hanya wajib untuk siswa
        if ($this->user()->isSiswa()) {
            $rules['nis'] = [
                'nullable',
                'string',
                'max:20',
                Rule::unique(User::class)->ignore($userId),
            ];
            $rules['phone'] = ['nullable', 'string', 'max:20'];
        }

        return $rules;
    }
}