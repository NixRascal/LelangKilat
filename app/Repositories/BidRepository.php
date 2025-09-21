<?php

namespace App\Repositories;

use App\Models\Auction;
use App\Models\Bid;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class BidRepository extends BaseRepository
{
    public function __construct(private readonly Bid $bid)
    {
        parent::__construct($bid);
    }

    public function list(array $filters = []): LengthAwarePaginator
    {
        $query = $this->applyFilters($filters)->with(['auction', 'user']);
        $query = $this->applySorting($query, $filters['sort'] ?? null);

        return $this->paginate($query, $filters);
    }

    public function create(Auction $auction, array $payload): Bid
    {
        return $auction->bids()->create($payload);
    }

    protected function filterAuction(Builder $query, int $value): Builder
    {
        return $query->where('auction_id', $value);
    }

    protected function filterUser(Builder $query, int $value): Builder
    {
        return $query->where('user_id', $value);
    }
}
