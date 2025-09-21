<?php

namespace App\Http\Requests\Api\V1\Auth;

use App\Enums\Role;
use App\Http\Requests\Api\V1\ApiRequest;
use Illuminate\Validation\Rule;

class RegisterRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => ['required', 'string', 'min:8'],
            'role' => ['nullable', Rule::in(array_column(Role::cases(), 'value'))],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama wajib diisi',
            'email.unique' => 'Email sudah digunakan',
            'password.min' => 'Kata sandi minimal 8 karakter',
        ];
    }
}
