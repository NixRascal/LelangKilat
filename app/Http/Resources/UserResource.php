<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
            'wallet_balance' => $this->wallet?->balance ?? 0,
            'created_at' => $this->created_at?->timezone('Asia/Jakarta')->toIso8601String(),
        ];
    }
}
