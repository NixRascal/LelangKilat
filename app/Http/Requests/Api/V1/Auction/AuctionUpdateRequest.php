<?php

namespace App\Http\Requests\Api\V1\Auction;

use App\Http\Requests\Api\V1\ApiRequest;

class AuctionUpdateRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
            'title' => ['sometimes', 'string', 'max:255'],
            'description' => ['sometimes', 'string'],
            'start_time' => ['sometimes', 'date'],
            'end_time' => ['sometimes', 'date', 'after:start_time'],
            'status' => ['sometimes', 'in:draft,active,completed,cancelled'],
            'category_id' => ['sometimes', 'exists:categories,id'],
        ];
    }
}
