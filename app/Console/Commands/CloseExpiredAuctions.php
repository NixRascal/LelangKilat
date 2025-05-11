<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Auction;
use Illuminate\Support\Facades\DB;

class CloseExpiredAuctions extends Command
{
    protected $signature = 'auction:close-expired';
    protected $description = 'Menutup lelang yang sudah melewati end_time';

    public function handle()
    {
        $expired = Auction::where('status', 'ACTIVE')
            ->where('end_time', '<=', now())
            ->get();

        foreach ($expired as $auction) {
            $auction->update([
                'status'      => 'CLOSED',
                'winner_id'   => $auction->highest_bidder_id,
                'final_price' => $auction->current_bid,
            ]);

            $this->info("Auction ID {$auction->id} ditutup.");
        }

        if ($expired->isEmpty()) {
            $this->info("Tidak ada auction yang ditutup.");
        }
    }
}
