<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Auth\ChangePasswordRequest;
use App\Http\Requests\Api\V1\Auth\ForgotPasswordRequest;
use App\Http\Requests\Api\V1\Auth\LoginRequest;
use App\Http\Requests\Api\V1\Auth\RegisterRequest;
use App\Http\Requests\Api\V1\Auth\ResetPasswordRequest;
use App\Services\AuthService;
use App\Support\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;

class AuthController extends Controller
{
    public function __construct(private readonly AuthService $auth)
    {
    }

    public function register(RegisterRequest $request)
    {
        $result = $this->auth->register($request->validated());

        return ApiResponse::success($result, 'Registrasi berhasil', Response::HTTP_CREATED);
    }

    public function login(LoginRequest $request)
    {
        $result = $this->auth->login(...$request->only(['email', 'password']));

        return ApiResponse::success($result, 'Login berhasil');
    }

    public function refresh(Request $request)
    {
        $request->validate(['refresh_token' => ['required', 'string']]);
        $result = $this->auth->refresh($request->user(), $request->string('refresh_token'));

        return ApiResponse::success($result, 'Token diperbarui');
    }

    public function logout(Request $request)
    {
        $this->auth->logout($request->user());

        return ApiResponse::success(null, 'Logout berhasil');
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        $this->auth->changePassword(
            $request->user(),
            $request->string('current_password'),
            $request->string('new_password'),
        );

        return ApiResponse::success(null, 'Kata sandi berhasil diganti');
    }

    public function forgotPassword(ForgotPasswordRequest $request)
    {
        $this->auth->forgotPassword($request->string('email'));

        return ApiResponse::success(null, 'Instruksi reset dikirim');
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        $this->auth->resetPassword($request->string('token'), $request->string('password'));

        return ApiResponse::success(null, 'Kata sandi berhasil direset');
    }
}
