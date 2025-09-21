<?php

namespace App\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;

abstract class BaseRepository
{
    protected Builder $query;

    public function __construct(protected Model $model)
    {
        $this->query = $model->newQuery();
    }

    protected function applyFilters(array $filters): Builder
    {
        $query = $this->model->newQuery();

        foreach ($filters as $key => $value) {
            if ($value === null || $value === '') {
                continue;
            }

            if (in_array($key, ['page', 'per_page', 'sort'], true)) {
                continue;
            }

            $method = 'filter'.ucfirst($key);
            if (method_exists($this, $method)) {
                $query = $this->{$method}($query, $value);
            } else {
                $query->where($key, $value);
            }
        }

        return $query;
    }

    protected function applySorting(Builder $query, ?string $sort): Builder
    {
        if (!$sort) {
            return $query->latest();
        }

        [$column, $direction] = array_pad(explode(':', $sort), 2, 'asc');
        $direction = strtolower($direction) === 'desc' ? 'desc' : 'asc';

        return $query->orderBy($column, $direction);
    }

    protected function paginate(Builder $query, array $options = []): LengthAwarePaginator
    {
        $page = (int) ($options['page'] ?? 1);
        $perPage = min((int) ($options['per_page'] ?? 15), 100);

        return $query->paginate($perPage, ['*'], 'page', $page);
    }

    protected function parseDate(?string $value): ?Carbon
    {
        if (!$value) {
            return null;
        }

        return Carbon::parse($value, config('app.timezone'))->setTimezone('UTC');
    }
}
