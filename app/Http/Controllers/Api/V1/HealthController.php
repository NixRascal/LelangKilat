<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class HealthController extends Controller
{
    public function live()
    {
        return response()->json(['status' => 'ok']);
    }

    public function ready()
    {
        DB::connection()->getPdo();
        Redis::connection()->ping();

        return response()->json(['status' => 'ready']);
    }
}
