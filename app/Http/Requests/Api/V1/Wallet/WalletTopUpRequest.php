<?php

namespace App\Http\Requests\Api\V1\Wallet;

use App\Http\Requests\Api\V1\ApiRequest;

class WalletTopUpRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
            'amount' => ['required', 'numeric', 'min:10000'],
            'description' => ['nullable', 'string'],
        ];
    }
}
