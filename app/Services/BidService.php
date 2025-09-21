<?php

namespace App\Services;

use App\Models\Auction;
use App\Models\Bid;
use App\Models\WalletTransaction;
use App\Repositories\AuditLogRepository;
use App\Repositories\BidRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class BidService
{
    public function __construct(
        private readonly BidRepository $bids,
        private readonly AuditLogRepository $auditLogs,
    ) {}

    public function paginate(array $filters = []): LengthAwarePaginator
    {
        return $this->bids->list($filters);
    }

    public function placeBid(Auction $auction, array $payload): Bid
    {
        return DB::transaction(function () use ($auction, $payload) {
            $user = auth()->user();
            $wallet = $user?->wallet()->lockForUpdate()->first();

            if (! $wallet) {
                $wallet = $user->wallet()->create([
                    'balance' => 0,
                    'reserved_balance' => 0,
                ]);
                $wallet->refresh();
            }

            if ($auction->end_time && Carbon::parse($auction->end_time)->isPast()) {
                abort(422, 'Lelang telah berakhir');
            }

            if ($payload['amount'] <= $auction->current_bid) {
                abort(422, 'Penawaran harus lebih tinggi dari tawaran saat ini');
            }

            $additionalAmount = $payload['amount'];

            if ($auction->highest_bidder_id === $user->id) {
                $additionalAmount -= $auction->current_bid;
            }

            if ($additionalAmount > 0 && $wallet->balance < $additionalAmount) {
                abort(422, 'Saldo dompet tidak mencukupi');
            }

            if ($additionalAmount > 0) {
                $wallet->decrement('balance', $additionalAmount);
                $wallet->increment('reserved_balance', $additionalAmount);

                WalletTransaction::create([
                    'wallet_id' => $wallet->id,
                    'type' => 'RESERVE',
                    'amount' => $additionalAmount,
                    'reference_type' => Auction::class,
                    'reference_id' => $auction->id,
                    'description' => 'Reservasi saldo untuk penawaran lelang',
                ]);
            }

            if ($auction->highest_bidder_id && $auction->highest_bidder_id !== $user->id) {
                $previousHighest = $auction->highestBidder()->with('wallet')->first();

                if ($previousHighest && $previousHighest->wallet) {
                    $previousWallet = $previousHighest->wallet()->lockForUpdate()->first();

                    if ($previousWallet) {
                        $releaseAmount = min($auction->current_bid, $previousWallet->reserved_balance);
                        $previousWallet->increment('balance', $releaseAmount);
                        $previousWallet->decrement('reserved_balance', $releaseAmount);

                        WalletTransaction::create([
                            'wallet_id' => $previousWallet->id,
                            'type' => 'RELEASE',
                            'amount' => $releaseAmount,
                            'reference_type' => Auction::class,
                            'reference_id' => $auction->id,
                            'description' => 'Rilis saldo karena penawar lain lebih tinggi',
                        ]);
                    }
                }
            }

            $bid = $this->bids->create($auction, $payload);
            $auction->forceFill([
                'current_bid' => $payload['amount'],
                'highest_bidder_id' => $payload['user_id'],
            ])->save();

            $this->auditLogs->create([
                'user_id' => $payload['user_id'],
                'module' => 'bid',
                'action' => 'create',
                'description' => 'Menempatkan penawaran',
                'payload' => ['auction_id' => $auction->id, 'amount' => $payload['amount']],
            ]);

            return $bid;
        });
    }
}
