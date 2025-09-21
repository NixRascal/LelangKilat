<?php

namespace App\Support;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class ApiResponse
{
    public static function success(
        mixed $data = null,
        string $message = 'Berhasil',
        int $status = Response::HTTP_OK,
        array $meta = []
    ): JsonResponse {
        if ($data instanceof AnonymousResourceCollection && $data->resource instanceof LengthAwarePaginator) {
            $paginator = $data->resource;
            $meta = array_merge($meta, [
                'total' => $paginator->total(),
                'per_page' => $paginator->perPage(),
                'current_page' => $paginator->currentPage(),
                'last_page' => $paginator->lastPage(),
            ]);
            $data = $data->collection;
        }

        if ($data instanceof LengthAwarePaginator) {
            $meta = array_merge($meta, [
                'total' => $data->total(),
                'per_page' => $data->perPage(),
                'current_page' => $data->currentPage(),
                'last_page' => $data->lastPage(),
            ]);
            $data = $data->items();
        }

        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data,
            'meta' => $meta,
        ], $status);
    }

    public static function error(
        string $userMessage,
        string $errorCode = 'ERR_GENERAL',
        string $logMessage = '',
        int $status = Response::HTTP_BAD_REQUEST,
        array $errors = []
    ): JsonResponse {
        return response()->json([
            'status' => 'error',
            'error_code' => $errorCode,
            'message' => $userMessage,
            'errors' => $errors,
        ], $status)->withHeaders([
            'X-Error-Log-Message' => $logMessage,
        ]);
    }
}
