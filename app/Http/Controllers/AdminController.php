<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Bid;
use App\Models\Auction;
use App\Models\AuctionImage;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function index(){
    }

    public function checking() {
        if (Auth::user()-> role !== "ADMIN"){
            return redirect("/")->with("error","Akses hanya untuk admin.");
        }
        return view("admin.dashboard");
    }

    public function dashboard() {
        $totalUsers = User::count();
        $totalAuctions = Auction::count();
        $activeAuctions = Auction::where('status', 'ACTIVE')->count();
        $todayAuctions = Auction::whereDate('created_at', Carbon::today())->count();
        $bidsToday = Bid::whereDate('created_at', Carbon::today())->count();
        
        $usersGrowth = collect();
        $dates = collect();

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i)->toDateString();
            $count = User::whereDate('created_at', $date)->count();
            $usersGrowth->push($count);
            $dates->push(Carbon::parse($date)->format('d M'));
        }

        return view("admin.dashboard",compact("totalUsers","totalAuctions","activeAuctions", "bidsToday", "todayAuctions"));
    }

    public function user() {
        $users = User::all();
        return view("admin.user.index",compact("users"));
    }

    public function auction() {
        $auctions = Auction::all();
        return view("admin.auction.index",compact("auctions"));
    }

    public function destoryAuction($id) {
        $auctions = Auction::find($id);
        $auctions->delete();
        return redirect("/admin/lelang")->with("success","Hapus Data Berhasil");
    }

    public function editAuction($id) {
        $auction = Auction::findOrFail($id);
        return view('admin.auction.edit', compact('auction'));
    }


    public function updateAuction(Request $request, $id) {
        $auctions = Auction::find($id);

        $validated = $request->validate([
            "title"=> "'required|max:255",
            "description"=> "required",
            "cetegory"=> "required",
            "starting_bid"=> "required",
            "status"=> "required",
        ]);

        if ($auctions->current_bid > $auctions->starting_bid && $request->starting_bid != $auctions->starting_bid) {
            return back()->with('error', 'Harga awal tidak dapat diubah karena sudah ada penawaran.');
        }
        
        $auctions->title = $request->title;
        $auctions->description = $request->description;
        
        if ($auctions->current_bid == $auctions->starting_bid) {
            $auctions->starting_bid = $request->starting_bid;
        }

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = 'auction_' . $auctions->id . '.' . $file->extension();
            $file->move(public_path('images'), $filename);
            $auctions->image_path = 'images/' . $filename;
        }        

        $auctions->end_time = $request->end_time;
        $auctions->save();
        
        return redirect("/admin/lelang")->with("success","Hapus Data Berhasil");
    }
}
