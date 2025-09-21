<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Wallet\WalletTopUpRequest;
use App\Http\Resources\WalletTransactionResource;
use App\Services\WalletService;
use App\Support\ApiResponse;
use Illuminate\Http\Response;

class WalletController extends Controller
{
    public function __construct(private readonly WalletService $wallets) {}

    public function index()
    {
        return ApiResponse::success(
            WalletTransactionResource::collection($this->wallets->paginate(request()->all()))
        );
    }

    public function topUp(WalletTopUpRequest $request)
    {
        $transaction = $this->wallets->topUp($request->user(), array_merge(
            $request->validated(),
            ['type' => 'CREDIT']
        ));

        return ApiResponse::success(new WalletTransactionResource($transaction), 'Saldo ditambahkan', Response::HTTP_CREATED);
    }
}
