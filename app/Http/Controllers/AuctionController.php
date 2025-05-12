<?php

namespace App\Http\Controllers;

use App\Models\Auction;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

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
    public function category($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        $auctions = Auction::with(['category'])
            ->where('category_id', $category->id)
            ->where('status', 'ACTIVE')
            ->latest()
            ->paginate(12);

        return view('user.auction.search_result', [
            'category' => $category,
            'auctions' => $auctions,
        ]);
    }

    public function search(Request $request)
    {
        $search = $request->input('search');
        $keywords = explode(' ', $search);

        $auctions = Auction::with('category')
            ->where('status', 'ACTIVE')
            ->where(function ($query) use ($keywords) {
                foreach ($keywords as $word) {
                    $query->orWhere('title', 'like', '%' . $word . '%')
                        ->orWhere('description', 'like', '%' . $word . '%');
                }
            })
            ->latest()
            ->paginate(12);

        $user = Auth::user();

        return view('user.auction.search_result', compact('auctions', 'user'));
    }
}
