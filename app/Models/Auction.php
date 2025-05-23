<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Auction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'starting_bid',
        'current_bid',
        'start_time',
        'end_time',
        'status',
        'winner_id',
        'final_price',
        'highest_bidder_id',
    ];

    public function owner() {
        return $this->belongsTo(User::class,'user_id');
    }

    public function winner() {
        return $this->belongsTo(User::class,'winner_id');
    }

    public function bids() {
        return $this->hasMany(Bid::class);
    }

    public function images() {
        return $this->hasMany(AuctionImage::class);
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }
    public function highestBidder() {
        return $this->belongsTo(User::class, 'highest_bidder_id');
    }

}
