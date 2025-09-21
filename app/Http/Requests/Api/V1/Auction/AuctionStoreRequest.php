<?php

namespace App\Http\Requests\Api\V1\Auction;

use App\Http\Requests\Api\V1\ApiRequest;

class AuctionStoreRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'starting_bid' => ['required', 'numeric', 'min:0'],
            'current_bid' => ['nullable', 'numeric', 'min:0'],
            'start_time' => ['required', 'date'],
            'end_time' => ['required', 'date', 'after:start_time'],
            'status' => ['required', 'in:draft,active,completed,cancelled'],
            'category_id' => ['required', 'exists:categories,id'],
        ];
    }
}
