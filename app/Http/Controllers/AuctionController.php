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
        $auction->load(['bids' => function ($query) {
            $query->with('user')->latest();
        }, 'owner']);

        return view('user.auction.show', [
            'auction' => $auction
        ]);
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

    public function mine()
    {
        $auctions = Auction::where('user_id', auth()->id())
            ->with(['bids' => function ($query) {
                $query->latest();
            }])
            ->latest()
            ->paginate(9);

        return view('user.auction.mine', [
            'auctions' => $auctions
        ]);
    }

    public function editUser($id)
    {
        $auction = \App\Models\Auction::where('user_id', auth()->id())->findOrFail($id);
        return view('user.auction.edit', compact('auction'));
    }

    public function updateUser(Request $request, $id)
    {
        $auction = \App\Models\Auction::where('user_id', auth()->id())->findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'starting_bid' => 'required|numeric|min:0',
            'start_time' => 'required|date',
            'duration_days' => 'nullable|integer|min:0',
            'duration_hours' => 'nullable|integer|min:0|max:23',
            'duration_minutes' => 'nullable|integer|min:0|max:59',
            'image' => 'nullable|image|max:2048',
        ]);

        $auction->title = $validated['title'];
        $auction->description = $validated['description'];

        if ($auction->current_bid <= $auction->starting_bid) {
            $auction->starting_bid = $validated['starting_bid'];
        }

        $auction->start_time = $validated['start_time'];
        $days = (int) $request->input('duration_days', 0);
        $hours = (int) $request->input('duration_hours', 0);
        $minutes = (int) $request->input('duration_minutes', 0);
        $auction->end_time = \Carbon\Carbon::parse($validated['start_time'])
            ->addDays($days)
            ->addHours($hours)
            ->addMinutes($minutes);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('uploads', 'public');
            $auction->image_path = 'storage/' . $imagePath;
        }

        $auction->save();

        return redirect()->route('auctions.mine')->with('success', 'Lelang berhasil diperbarui');
    }

    public function participated()
    {
        $userId = auth()->id();
        $auctionIds = \App\Models\Bid::where('user_id', $userId)->pluck('auction_id')->unique();
        $auctions = \App\Models\Auction::whereIn('id', $auctionIds)->latest()->paginate(9);

        return view('user.auction.participated', [
            'auctions' => $auctions
        ]);
    }

    public function participationDetail($auctionId)
    {
        $auction = \App\Models\Auction::with('category')->findOrFail($auctionId);
        $user = auth()->user();

        // Ambil semua bid user pada lelang ini
        $userBids = $auction->bids()->where('user_id', $user->id)->orderByDesc('created_at')->get();

        return view('user.auction.participation_detail', [
            'auction' => $auction,
            'userBids' => $userBids,
        ]);
    }
}
