<?php

namespace App\Http\Requests\Api\V1\Category;

use App\Http\Requests\Api\V1\ApiRequest;
use Illuminate\Validation\Rule;

class CategoryUpdateRequest extends ApiRequest
{
    public function rules(): array
    {
        $categoryId = $this->route('category')?->id ?? null;

        return [
            'name' => ['sometimes', 'string', 'max:120'],
            'slug' => ['sometimes', 'string', 'max:120', Rule::unique('categories', 'slug')->ignore($categoryId)],
            'icon_path' => ['sometimes', 'nullable', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'slug.unique' => 'Slug sudah digunakan',
        ];
    }
}
