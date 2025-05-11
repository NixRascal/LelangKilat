<?php

namespace App\Http\Controllers;

use App\Models\Auction;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class AuctionController extends Controller
{
    public function show(Auction $auction)
    {
        $auction->load([
            'bids.user',         // untuk riwayat penawaran
            'owner',             // pengguna yang membuat lelang
            'category',          // kategori barang
            'highestBidder'      // penawar tertinggi (jika pakai highest_bidder_id)
        ]);
    
        return view('user.auction.show', compact('auction'));
    }
    
}
