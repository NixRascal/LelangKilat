<?php

namespace App\Models;

use App\Models\Bid;
use App\Models\Wallet;
use App\Models\Auction;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'profile_photo',
    ];
    
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function wallet() {
        return $this->hasOne(Wallet::class);
    }
    public function auctions() {
        return $this->hasMany(Auction::class);
    }
    public function bids() {
        return $this->hasMany(Bid::class);
    }
}
