<?php
namespace App\Http\Controllers;

use App\Models\Auction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BidController extends Controller
{
    public function store(Request $request, Auction $auction)
    {
        $user = Auth::user();
        $wallet = $user->wallet;

        $minBid = $auction->current_bid + $auction->bid_increment;

        // ✅ Validasi nilai tawaran
        $request->validate([
            'amount' => "required|numeric|min:$minBid",
        ]);

        // ✅ Lelang sudah selesai
        if (now()->greaterThan($auction->end_time)) {
            return back()->withErrors(['amount' => 'Lelang sudah berakhir.']);
        }

        // ✅ User sudah jadi penawar tertinggi
        if ($auction->highest_bidder_id === $user->id) {
            return back()->withErrors(['amount' => 'Kamu sudah menjadi penawar tertinggi.']);
        }

        // ✅ Saldo cukup?
        if ($wallet->balance < $request->amount) {
            return back()->withErrors(['amount' => 'Saldo tidak mencukupi untuk memasang penawaran.']);
        }

        // ✅ Ambil penawar tertinggi sebelumnya (jika ada)
        $previous = $auction->bids()
            ->where('user_id', $auction->highest_bidder_id)
            ->latest()
            ->first();

        if ($previous && $previous->user && $previous->user->wallet) {
            $prevWallet = $previous->user->wallet;

            // ✅ Kembalikan saldo dari penawar sebelumnya
            $prevWallet->update([
                'balance'          => $prevWallet->balance + $previous->amount,
                'reserved_balance' => $prevWallet->reserved_balance - $previous->amount,
            ]);
        }

        // ✅ Simpan penawaran baru
        $auction->bids()->create([
            'user_id'     => $user->id,
            'amount'      => $request->amount,
            'hold_status' => 'held',
        ]);

        // ✅ Tahan saldo penawar baru
        $wallet->update([
            'balance'          => $wallet->balance - $request->amount,
            'reserved_balance' => $wallet->reserved_balance + $request->amount,
        ]);

        // ✅ Update auction
        $auction->update([
            'current_bid'       => $request->amount,
            'highest_bidder_id' => $user->id,
        ]);

        return back()->with('success', 'Penawaran berhasil dan saldo ditahan.');
    }
}
