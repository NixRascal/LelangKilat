<?php

namespace App\Repositories;

use App\Enums\Role;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class UserRepository extends BaseRepository
{
    public function __construct(private readonly User $user)
    {
        parent::__construct($user);
    }

    public function list(array $filters = []): LengthAwarePaginator
    {
        $query = $this->applyFilters($filters)->with('wallet');
        $query = $this->applySorting($query, $filters['sort'] ?? null);

        return $this->paginate($query, $filters);
    }

    public function create(array $payload): User
    {
        return $this->user->create($payload);
    }

    public function update(User $user, array $payload): User
    {
        $user->update($payload);

        return $user->refresh();
    }

    protected function filterRole(Builder $query, string $value): Builder
    {
        return $query->where('role', Role::from($value)->value);
    }

    protected function filterSearch(Builder $query, string $value): Builder
    {
        return $query->where(fn (Builder $q) => $q
            ->where('name', 'like', "%{$value}%")
            ->orWhere('email', 'like', "%{$value}%")
        );
    }
}
