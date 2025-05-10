<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Bid;
use App\Models\Auction;
use App\Models\User;
use App\Models\AuctionImage;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function index(){
    }

    public function checking() {
        if (Auth::user()-> role !== "ADMIN"){
            return redirect("/")->with("error","Akses hanya untuk admin.");
        }
        return view("admin.dashboard.index");
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

        return view("admin.dashboard.index",compact("totalUsers","totalAuctions","activeAuctions", "bidsToday", "todayAuctions"));
    }

    public function user() {
        $users = User::where('role', 'USER')->get();
        return view("admin.user.index",compact("users"));
    }

    public function editUser($id) {
        $users = User::find($id);
        return view('admin.user.edit', compact('users'));
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'password' => 'nullable|string|min:6',
        ]);

        $user->name = $validated['name'];

        if ($request->filled('password')) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect("/admin/pengguna")->with("success","Data pengguna berhasil diperbarui");
    }

    public function destroyUser($id) {
        $users = User::find($id);
        $users->delete();
        return redirect("/admin/pengguna")->with("success","Hapus Data Berhasil");
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
    
    public function updateAuction(Request $request, $id)
    {
        $auction = Auction::findOrFail($id);
    
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'starting_bid' => 'required|numeric|min:0',
            'end_time' => 'required|date',
            'image' => 'nullable|image|max:2048',
        ]);
    
        $auction->title = $validated['title'];
        $auction->description = $validated['description'];
    
        if ($auction->current_bid <= $auction->starting_bid) {
            $auction->starting_bid = $validated['starting_bid'];
        }
    
        $auction->end_time = $validated['end_time'];
    
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('uploads', 'public');
            $auction->image_path = 'storage/' . $imagePath;
        }
    
        $auction->save();

        return redirect("/admin/lelang")->with("success","Data berhasil diperbarui");
    }    

    public function admins() {
        $admins = User::where('role', 'ADMIN')->get();
        return view("admin.admins.index",compact("admins"));
    }

    public function createAdmin()
    {
        return view('admin.admins.create');
    }

    public function storeAdmin(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'ADMIN',
            'profile_photo' => null,
        ]);
        return redirect("/admin/akunadmin")->with("success","Akun admin berhasil ditambahkan");
    }
    
    public function destroyAdmins($id) {
        $users = User::find($id);
        $users->delete();
        return redirect("/admin/akunadmin")->with("success","Hapus Data Berhasil");
    }

    public function editAdmins($id) {
        $admins = User::find($id);
        return view('admin.admins.edit', compact('admins'));
    }

    public function updateAdmins(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'password' => 'nullable|string|min:6',
        ]);

        $user->name = $validated['name'];

        if ($request->filled('password')) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect("/admin/akunadmin")->with("success","Data pengguna berhasil diperbarui");
    }
}
