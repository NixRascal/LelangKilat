<?php

namespace App\Repositories;

use App\Models\Auction;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class AuctionRepository extends BaseRepository
{
    public function __construct(private readonly Auction $auction)
    {
        parent::__construct($auction);
    }

    public function list(array $filters = [], ?string $sort = null): LengthAwarePaginator
    {
        $query = $this->applyFilters($filters);
        $query = $this->applySorting($query->with(['owner', 'category', 'highestBidder']), $sort);

        return $this->paginate($query, $filters);
    }

    public function find(int $id): Auction
    {
        return $this->auction->with(['owner', 'category', 'bids.user', 'images'])->findOrFail($id);
    }

    public function create(array $payload): Auction
    {
        return $this->auction->create($payload);
    }

    public function update(Auction $auction, array $payload): Auction
    {
        $auction->update($payload);

        return $auction->refresh();
    }

    public function delete(Auction $auction): void
    {
        $auction->delete();
    }

    protected function filterStatus(Builder $query, string $value): Builder
    {
        return $query->where('status', $value);
    }

    protected function filterCategory(Builder $query, string $value): Builder
    {
        return $query->whereHas('category', fn (Builder $q) => $q->where('slug', $value));
    }

    protected function filterOwner(Builder $query, int $value): Builder
    {
        return $query->where('user_id', $value);
    }

    protected function filterSearch(Builder $query, string $value): Builder
    {
        return $query->where(fn (Builder $q) => $q
            ->where('title', 'like', "%{$value}%")
            ->orWhere('description', 'like', "%{$value}%")
        );
    }
}
