<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Support\ApiResponse;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function profile(Request $request)
    {
        return ApiResponse::success([
            'user' => $request->user(),
            'preferences' => $request->user()->preferences ?? [],
        ]);
    }

    public function updatePreferences(Request $request)
    {
        $data = $request->validate([
            'language' => ['sometimes', 'string'],
            'theme' => ['sometimes', 'in:light,dark'],
            'timezone' => ['sometimes', 'string'],
        ]);

        $request->user()->forceFill([
            'preferences' => array_merge($request->user()->preferences ?? [], $data),
        ])->save();

        return ApiResponse::success([
            'preferences' => $request->user()->preferences,
        ], 'Preferensi diperbarui');
    }
}
