<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use Carbon\Carbon;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Auction;        // pastikan model Auction ada
use App\Models\AuctionImage;   // jika pakai model ini untuk cover

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $auctions = Auction::with(['category'])
            ->latest()
            ->paginate(12);
    
        $user = Auth::user();
        $ads = Ad::all();
        return view('user.home', [
            'user' => $user,
            'auctions' => $auctions,
            'categories' => $categories,
            'ads' => $ads,
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

        return view('user.search_result', compact('auctions', 'user'));
    }

}