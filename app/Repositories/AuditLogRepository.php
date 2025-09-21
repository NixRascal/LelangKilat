<?php

namespace App\Repositories;

use App\Models\AuditLog;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class AuditLogRepository extends BaseRepository
{
    public function __construct(private readonly AuditLog $auditLog)
    {
        parent::__construct($auditLog);
    }

    public function list(array $filters = []): LengthAwarePaginator
    {
        $query = $this->applyFilters($filters)->with('user');
        $query = $this->applySorting($query, $filters['sort'] ?? null);

        return $this->paginate($query, $filters);
    }

    public function create(array $payload): AuditLog
    {
        $default = [
            'request_id' => request()->header('X-Request-Id'),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ];

        return $this->auditLog->create(array_merge($default, $payload));
    }

    protected function filterModule(Builder $query, string $value): Builder
    {
        return $query->where('module', $value);
    }

    protected function filterAction(Builder $query, string $value): Builder
    {
        return $query->where('action', $value);
    }

    protected function filterSearch(Builder $query, string $value): Builder
    {
        return $query->where('description', 'like', "%{$value}%");
    }
}
