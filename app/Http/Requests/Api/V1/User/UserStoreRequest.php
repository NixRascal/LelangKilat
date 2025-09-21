<?php

namespace App\Http\Requests\Api\V1\User;

use App\Enums\Role;
use App\Http\Requests\Api\V1\ApiRequest;
use Illuminate\Validation\Rule;

class UserStoreRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => ['required', 'string', 'min:8'],
            'role' => ['required', Rule::in(array_column(Role::cases(), 'value'))],
        ];
    }
}
