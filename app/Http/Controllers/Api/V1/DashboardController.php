<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\DashboardService;
use App\Support\ApiResponse;

class DashboardController extends Controller
{
    public function __construct(private readonly DashboardService $dashboard) {}

    public function index()
    {
        return ApiResponse::success([
            'metrics' => $this->dashboard->metrics(),
            'trend_bid' => $this->dashboard->trendBid(),
            'tasks' => $this->dashboard->latestTasks(),
        ]);
    }
}
