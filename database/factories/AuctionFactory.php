<?php

namespace Database\Factories;

use App\Models\Auction;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AuctionFactory extends Factory
{
    protected $model = Auction::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'category_id' => Category::factory(),
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(),
            'starting_bid' => 100000,
            'current_bid' => 100000,
            'start_time' => now()->addHour(),
            'end_time' => now()->addHours(2),
            'status' => 'draft',
        ];
    }
}
