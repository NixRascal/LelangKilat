<?php

namespace App\Services;

use App\Repositories\AuditLogRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class AuditLogService
{
    public function __construct(private readonly AuditLogRepository $auditLogs) {}

    public function paginate(array $filters = []): LengthAwarePaginator
    {
        return $this->auditLogs->list($filters);
    }
}
