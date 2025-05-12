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
}