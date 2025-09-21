<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\AuditLogResource;
use App\Services\AuditLogService;
use App\Support\ApiResponse;

class AuditLogController extends Controller
{
    public function __construct(private readonly AuditLogService $auditLogs) {}

    public function index()
    {
        return ApiResponse::success(
            AuditLogResource::collection($this->auditLogs->paginate(request()->all()))
        );
    }
}
