<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\Wallet;
use App\Models\WalletTransaction;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

class WalletRepository extends BaseRepository
{
    public function __construct(private readonly WalletTransaction $transaction)
    {
        parent::__construct($transaction);
    }

    public function list(array $filters = []): LengthAwarePaginator
    {
        $query = $this->applyFilters($filters)->with(['wallet.user']);
        $query = $this->applySorting($query, $filters['sort'] ?? null);

        return $this->paginate($query, $filters);
    }

    public function create(User $user, array $payload): WalletTransaction
    {
        $wallet = $user->wallet()->firstOrCreate([]);
        $transaction = $wallet->transactions()->create($payload);

        if ($payload['type'] === 'CREDIT') {
            $wallet->increment('balance', $payload['amount']);
        } else {
            $wallet->decrement('balance', $payload['amount']);
        }

        return $transaction->refresh();
    }

    protected function filterUser(Builder $query, int $value): Builder
    {
        return $query->whereHas('wallet', fn (Builder $q) => $q->where('user_id', $value));
    }

    protected function filterDateFrom(Builder $query, string $value): Builder
    {
        return $query->whereDate('created_at', '>=', Carbon::parse($value));
    }

    protected function filterDateTo(Builder $query, string $value): Builder
    {
        return $query->whereDate('created_at', '<=', Carbon::parse($value));
    }
}
