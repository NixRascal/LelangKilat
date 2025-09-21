<?php

namespace App\Http\Requests\Api\V1\User;

use App\Enums\Role;
use App\Http\Requests\Api\V1\ApiRequest;
use Illuminate\Validation\Rule;

class UserUpdateRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
            'name' => ['sometimes', 'string', 'max:120'],
            'email' => ['sometimes', 'email', Rule::unique('users', 'email')->ignore($this->route('user'))],
            'password' => ['nullable', 'string', 'min:8'],
            'role' => ['sometimes', Rule::in(array_column(Role::cases(), 'value'))],
        ];
    }
}
