<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Auction\AuctionStoreRequest;
use App\Http\Requests\Api\V1\Auction\AuctionUpdateRequest;
use App\Http\Requests\Api\V1\Auction\BidStoreRequest;
use App\Http\Resources\AuctionResource;
use App\Http\Resources\BidResource;
use App\Models\Auction;
use App\Services\AuctionService;
use App\Services\BidService;
use App\Support\ApiResponse;
use Illuminate\Http\Response;

class AuctionController extends Controller
{
    public function __construct(
        private readonly AuctionService $auctions,
        private readonly BidService $bids,
    ) {}

    public function index()
    {
        return ApiResponse::success(
            AuctionResource::collection($this->auctions->paginate(request()->all()))
        );
    }

    public function store(AuctionStoreRequest $request)
    {
        $payload = array_merge($request->validated(), [
            'user_id' => $request->user()->id,
            'current_bid' => $request->input('starting_bid'),
        ]);

        $auction = $this->auctions->create($payload);

        return ApiResponse::success(new AuctionResource($auction), 'Lelang dibuat', Response::HTTP_CREATED);
    }

    public function show(int $id)
    {
        $auction = $this->auctions->show($id);

        return ApiResponse::success(new AuctionResource($auction));
    }

    public function update(AuctionUpdateRequest $request, Auction $auction)
    {
        $updated = $this->auctions->update($auction, $request->validated());

        return ApiResponse::success(new AuctionResource($updated), 'Lelang diperbarui');
    }

    public function destroy(Auction $auction)
    {
        $this->auctions->destroy($auction);

        return ApiResponse::success(null, 'Lelang dihapus', Response::HTTP_NO_CONTENT);
    }

    public function bids(Auction $auction)
    {
        return ApiResponse::success(
            BidResource::collection($auction->bids()->with('user')->paginate(request('per_page', 10)))
        );
    }

    public function placeBid(BidStoreRequest $request, Auction $auction)
    {
        $payload = array_merge($request->validated(), [
            'user_id' => $request->user()->id,
        ]);

        $bid = $this->bids->placeBid($auction, $payload);

        return ApiResponse::success(new BidResource($bid->load('user')), 'Penawaran berhasil', Response::HTTP_CREATED);
    }
}
