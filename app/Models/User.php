<?php

namespace App\Models;

use App\Enums\Role;
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
        'preferences',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'preferences' => 'array',
    ];

    protected $attributes = [
        'role' => 'user',
    ];

    public function isRole(Role $role): bool
    {
        return $this->role === $role->value;
    }

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
