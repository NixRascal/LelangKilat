<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AuctionResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'starting_bid' => $this->starting_bid,
            'current_bid' => $this->current_bid,
            'start_time' => $this->start_time?->timezone('Asia/Jakarta')->toIso8601String(),
            'end_time' => $this->end_time?->timezone('Asia/Jakarta')->toIso8601String(),
            'status' => $this->status,
            'category' => $this->whenLoaded('category', fn () => [
                'id' => $this->category->id,
                'name' => $this->category->name,
            ]),
            'owner' => $this->whenLoaded('owner', fn () => [
                'id' => $this->owner->id,
                'name' => $this->owner->name,
            ]),
            'highest_bidder' => $this->whenLoaded('highestBidder', fn () => [
                'id' => $this->highestBidder->id,
                'name' => $this->highestBidder->name,
            ]),
            'images' => $this->whenLoaded('images', fn () => $this->images->map(fn ($image) => [
                'id' => $image->id,
                'url' => $image->image_path,
            ])),
        ];
    }
}
