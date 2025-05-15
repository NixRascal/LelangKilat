<?php

namespace App\Http\Controllers;

use App\Models\Auction;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class AuctionController extends Controller
{   
    public function index()
    {
        $auctions = \App\Models\Auction::with('category')->latest()->paginate(12);
        return view('user.auction.index', compact('auctions'));
    }
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

    public function create()
    {
        // Jika ada kategori, bisa diambil dari model Category
        $categories = Category::all();
        return view('user.auction.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'item_name' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'start_price' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'duration_days' => 'nullable|integer|min:0',
            'duration_hours' => 'nullable|integer|min:0|max:23',
            'duration_minutes' => 'nullable|integer|min:0|max:59',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $auction = new Auction();
        $auction->title = $request->item_name;
        $auction->description = $request->description;
        $auction->category_id = $request->category_id;
        $auction->starting_bid = $request->start_price;
        $auction->current_bid = null;
        $auction->bid_increment = 1000;
        $auction->highest_bidder_id = null;
        $startDate = $request->start_date;
        $days = (int) $request->input('duration_days', 0);
        $hours = (int) $request->input('duration_hours', 0);
        $minutes = (int) $request->input('duration_minutes', 0);
        $endDate = \Carbon\Carbon::parse($startDate)
            ->addDays($days)
            ->addHours($hours)
            ->addMinutes($minutes);
        $auction->start_time = $startDate;
        $auction->end_time = $endDate;
        $auction->user_id = Auth::id();
        $auction->status = 'ACTIVE';
        $auction->winner_id = null;
        $auction->final_price = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time().'_'.$image->getClientOriginalName();
            $image->move(public_path('storage/uploads/auction_picture'), $imageName);
            $auction->image_path = 'storage/uploads/auction_picture/' . $imageName;
        } else {
            $auction->image_path = null;
        }
        $auction->save();

        return redirect()->route('auctions.mine')->with('success', 'Lelang berhasil dibuat!');
    }
}
