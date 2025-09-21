<?php

namespace App\Services;

use App\Enums\Role;
use App\Models\Auction;
use App\Repositories\AuctionRepository;
use App\Repositories\AuditLogRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;

class AuctionService
{
    public function __construct(
        private readonly AuctionRepository $auctions,
        private readonly AuditLogRepository $auditLogs,
    ) {}

    public function paginate(array $filters = []): LengthAwarePaginator
    {
        return $this->auctions->list($filters, $filters['sort'] ?? null);
    }

    public function show(int $id): Auction
    {
        return $this->auctions->find($id);
    }

    public function create(array $payload): Auction
    {
        $auction = $this->auctions->create($payload);

        $this->auditLogs->create([
            'user_id' => auth()->id(),
            'module' => 'auction',
            'action' => 'create',
            'description' => 'Membuat lelang',
            'payload' => ['id' => $auction->id],
        ]);

        return $auction;
    }

    public function update(Auction $auction, array $payload): Auction
    {
        $updated = $this->auctions->update($auction, $payload);

        $this->auditLogs->create([
            'user_id' => auth()->id(),
            'module' => 'auction',
            'action' => 'update',
            'description' => 'Memperbarui lelang',
            'payload' => ['id' => $auction->id],
        ]);

        return $updated;
    }

    public function destroy(Auction $auction): void
    {
        $this->auctions->delete($auction);
        $this->auditLogs->create([
            'user_id' => auth()->id(),
            'module' => 'auction',
            'action' => 'delete',
            'description' => 'Menghapus lelang',
            'payload' => ['id' => $auction->id],
        ]);
    }
}
