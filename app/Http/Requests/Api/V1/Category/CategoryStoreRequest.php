<?php

namespace App\Http\Requests\Api\V1\Category;

use App\Http\Requests\Api\V1\ApiRequest;
use Illuminate\Validation\Rule;

class CategoryStoreRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:120'],
            'slug' => ['required', 'string', 'max:120', Rule::unique('categories', 'slug')],
            'icon_path' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama kategori wajib diisi',
            'slug.required' => 'Slug wajib diisi',
            'slug.unique' => 'Slug sudah digunakan',
        ];
    }
}
