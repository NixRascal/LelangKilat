<?php

namespace App\Services;

use App\Models\Auction;
use App\Models\Bid;
use App\Models\User;
use App\Models\WalletTransaction;
use Illuminate\Support\Carbon;

class DashboardService
{
    public function metrics(): array
    {
        $today = Carbon::now('Asia/Jakarta')->startOfDay();

        return [
            'total_pengguna' => User::count(),
            'lelang_aktif' => Auction::where('status', 'active')->count(),
            'total_transaksi_hari_ini' => WalletTransaction::whereDate('created_at', $today)->sum('amount'),
            'total_bid' => Bid::count(),
        ];
    }

    public function trendBid(): array
    {
        return Bid::selectRaw('DATE(created_at) as tanggal, COUNT(*) as total')
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->limit(14)
            ->get()
            ->map(fn ($item) => [
                'tanggal' => Carbon::parse($item->tanggal)->locale('id_ID')->isoFormat('DD MMM'),
                'total' => (int) $item->total,
            ])->toArray();
    }

    public function latestTasks(): array
    {
        return Auction::latest()->take(5)->get(['id', 'title', 'status'])->toArray();
    }
}
