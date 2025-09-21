<?php

namespace App\Repositories;

use App\Models\Category;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class CategoryRepository extends BaseRepository
{
    public function __construct(private readonly Category $category)
    {
        parent::__construct($category);
    }

    public function list(array $filters = []): LengthAwarePaginator
    {
        $query = $this->applyFilters($filters);
        $query = $this->applySorting($query, $filters['sort'] ?? null);

        return $this->paginate($query, $filters);
    }

    public function create(array $payload): Category
    {
        return $this->category->create($payload);
    }

    public function update(Category $category, array $payload): Category
    {
        $category->update($payload);

        return $category->refresh();
    }

    public function delete(Category $category): void
    {
        $category->delete();
    }

    protected function filterSearch(Builder $query, string $value): Builder
    {
        return $query->where(fn (Builder $q) => $q
            ->where('name', 'like', "%{$value}%")
            ->orWhere('slug', 'like', "%{$value}%")
        );
    }
}
