<?php

namespace App\Http\Middleware;

use App\Enums\Role;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureRole
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if (!$user) {
            abort(Response::HTTP_UNAUTHORIZED, 'Tidak terautentikasi');
        }

        $userRole = Role::from($user->role);
        $allowed = collect($roles)
            ->map(fn ($role) => Role::from($role))
            ->contains(fn (Role $role) => $userRole->canManage($role));

        abort_unless($allowed, Response::HTTP_FORBIDDEN, 'Anda tidak memiliki akses');

        return $next($request);
    }
}
