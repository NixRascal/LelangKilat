<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\ReportService;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ReportController extends Controller
{
    public function __construct(private readonly ReportService $reports) {}

    public function exportAuctions(): BinaryFileResponse
    {
        $path = $this->reports->exportAuctions(request()->all());

        return response()->download($path, basename($path), [
            'Content-Type' => 'text/csv',
        ])->deleteFileAfterSend();
    }
}
