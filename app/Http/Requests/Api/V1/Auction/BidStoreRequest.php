<?php

namespace App\Http\Requests\Api\V1\Auction;

use App\Http\Requests\Api\V1\ApiRequest;

class BidStoreRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
            'amount' => ['required', 'numeric', 'min:1'],
        ];
    }
}
