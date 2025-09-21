<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Models\Category
 */
class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'icon_path' => $this->icon_path,
            'created_at' => optional($this->created_at)?->setTimezone('Asia/Jakarta')->toIso8601String(),
            'updated_at' => optional($this->updated_at)?->setTimezone('Asia/Jakarta')->toIso8601String(),
        ];
    }
}
