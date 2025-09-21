<?php

namespace App\Services;

use App\Enums\Role;
use App\Models\User;
use App\Repositories\AuditLogRepository;
use App\Repositories\UserRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function __construct(
        private readonly UserRepository $users,
        private readonly AuditLogRepository $auditLogs,
    ) {}

    public function paginate(array $filters = []): LengthAwarePaginator
    {
        return $this->users->list($filters);
    }

    public function create(array $payload): User
    {
        $payload['password'] = Hash::make($payload['password']);
        $user = $this->users->create($payload);

        $this->auditLogs->create([
            'user_id' => auth()->id(),
            'module' => 'user',
            'action' => 'create',
            'description' => 'Membuat pengguna baru',
            'payload' => ['id' => $user->id],
        ]);

        return $user;
    }

    public function update(User $user, array $payload): User
    {
        if (isset($payload['password'])) {
            $payload['password'] = Hash::make($payload['password']);
        }

        $updated = $this->users->update($user, $payload);

        $this->auditLogs->create([
            'user_id' => auth()->id(),
            'module' => 'user',
            'action' => 'update',
            'description' => 'Memperbarui pengguna',
            'payload' => ['id' => $user->id],
        ]);

        return $updated;
    }

    public function destroy(User $user): void
    {
        $user->delete();
        $this->auditLogs->create([
            'user_id' => auth()->id(),
            'module' => 'user',
            'action' => 'delete',
            'description' => 'Menghapus pengguna',
            'payload' => ['id' => $user->id],
        ]);
    }
}
