<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Auction;        // pastikan model Auction ada
use App\Models\AuctionImage;   // jika pakai model ini untuk cover

class HomeController extends Controller
{
    public function index()
{
    $categories = Category::all();
    $auctions = Auction::with(['category', 'coverImage'])
        ->where('status', 'ACTIVE')
        ->latest()
        ->paginate(12);

    return view('home', compact('categories', 'auctions'));
}
}
