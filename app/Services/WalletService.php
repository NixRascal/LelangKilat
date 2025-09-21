<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\AuditLogRepository;
use App\Repositories\WalletRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class WalletService
{
    public function __construct(
        private readonly WalletRepository $wallets,
        private readonly AuditLogRepository $auditLogs,
    ) {}

    public function paginate(array $filters = []): LengthAwarePaginator
    {
        return $this->wallets->list($filters);
    }

    public function topUp(User $user, array $payload)
    {
        $payload['type'] = strtoupper($payload['type'] ?? 'CREDIT');
        $transaction = $this->wallets->create($user, $payload);
        $this->auditLogs->create([
            'user_id' => $user->id,
            'module' => 'wallet',
            'action' => 'topup',
            'description' => 'Top up dompet',
            'payload' => ['amount' => $payload['amount']],
        ]);

        return $transaction;
    }
}
