<?php

namespace App\Services;

use App\Enums\Role;
use App\Models\User;
use App\Repositories\AuditLogRepository;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthService
{
    public function __construct(
        private readonly AuditLogRepository $auditLogs
    ) {}

    public function register(array $payload): array
    {
        $payload['password'] = Hash::make($payload['password']);
        $payload['role'] = $payload['role'] ?? Role::User->value;

        $user = User::create($payload);
        event(new Registered($user));
        $token = $user->createToken('api-token', ['*']);
        $refreshToken = Str::random(64);
        $user->forceFill(['remember_token' => hash('sha256', $refreshToken)])->save();

        $this->auditLogs->create([
            'user_id' => $user->id,
            'module' => 'auth',
            'action' => 'register',
            'description' => 'Registrasi pengguna baru',
            'payload' => ['email' => $user->email],
        ]);

        return [
            'user' => $user,
            'token' => $token->plainTextToken,
            'refresh_token' => $refreshToken,
        ];
    }

    public function login(string $email, string $password): array
    {
        $user = User::where('email', $email)->first();

        if (!$user || !Hash::check($password, $user->password)) {
            throw new AuthenticationException('Email atau kata sandi salah');
        }

        $user->tokens()->delete();
        $tokenResult = $user->createToken('api-token', ['*']);
        $refreshToken = Str::random(64);
        $user->forceFill(['remember_token' => hash('sha256', $refreshToken)])->save();

        $this->auditLogs->create([
            'user_id' => $user->id,
            'module' => 'auth',
            'action' => 'login',
            'description' => 'Login berhasil',
        ]);

        return [
            'token' => $tokenResult->plainTextToken,
            'refresh_token' => $refreshToken,
            'user' => $user,
        ];
    }

    public function refresh(User $user, string $refreshToken): array
    {
        if (!hash_equals($user->remember_token ?? '', hash('sha256', $refreshToken))) {
            throw new AuthenticationException('Refresh token tidak valid');
        }

        $user->tokens()->delete();
        $tokenResult = $user->createToken('api-token', ['*']);
        $newRefreshToken = Str::random(64);
        $user->forceFill(['remember_token' => hash('sha256', $newRefreshToken)])->save();

        return [
            'token' => $tokenResult->plainTextToken,
            'refresh_token' => $newRefreshToken,
        ];
    }

    public function logout(User $user): void
    {
        $user->tokens()->delete();
        $user->forceFill(['remember_token' => null])->save();
    }

    public function changePassword(User $user, string $currentPassword, string $newPassword): void
    {
        if (!Hash::check($currentPassword, $user->password)) {
            throw new AuthenticationException('Kata sandi saat ini salah');
        }

        $user->forceFill(['password' => Hash::make($newPassword)])->save();
    }

    public function forgotPassword(string $email): void
    {
        $user = User::where('email', $email)->firstOrFail();
        $token = Str::random(64);

        $user->forceFill(['remember_token' => hash('sha256', $token)])->save();
        // In real app send email job
    }

    public function resetPassword(string $token, string $newPassword): void
    {
        $user = User::where('remember_token', hash('sha256', $token))->firstOrFail();
        $user->forceFill([
            'password' => Hash::make($newPassword),
            'remember_token' => null,
        ])->save();

        event(new PasswordReset($user));
    }
}
