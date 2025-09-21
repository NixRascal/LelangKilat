<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AuditLogResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'module' => $this->module,
            'action' => $this->action,
            'description' => $this->description,
            'user' => $this->whenLoaded('user', fn () => [
                'id' => $this->user->id,
                'name' => $this->user->name,
            ]),
            'created_at' => $this->created_at?->timezone('Asia/Jakarta')->toIso8601String(),
        ];
    }
}
