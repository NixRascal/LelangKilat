<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AuctionImageSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('auction_images')->insert([
            // Auction ID 1
            ['auction_id' => 1, 'image_path' => 'images/auction1_cover.jpg', 'is_cover' => true],
            ['auction_id' => 1, 'image_path' => 'images/auction1_2.jpg', 'is_cover' => false],

            // Auction ID 2
            ['auction_id' => 2, 'image_path' => 'images/auction2_cover.jpg', 'is_cover' => true],
            ['auction_id' => 2, 'image_path' => 'images/auction2_2.jpg', 'is_cover' => false],

            // Auction ID 3
            ['auction_id' => 3, 'image_path' => 'images/auction3_cover.jpg', 'is_cover' => true],
            ['auction_id' => 3, 'image_path' => 'images/auction3_2.jpg', 'is_cover' => false],

            // Auction ID 4
            ['auction_id' => 4, 'image_path' => 'images/auction4_cover.jpg', 'is_cover' => true],
            ['auction_id' => 4, 'image_path' => 'images/auction4_2.jpg', 'is_cover' => false],

            // Auction ID 5
            ['auction_id' => 5, 'image_path' => 'images/auction5_cover.jpg', 'is_cover' => true],
            ['auction_id' => 5, 'image_path' => 'images/auction5_2.jpg', 'is_cover' => false],

            // Auction ID 6
            ['auction_id' => 6, 'image_path' => 'images/auction6_cover.jpg', 'is_cover' => true],
            ['auction_id' => 6, 'image_path' => 'images/auction6_2.jpg', 'is_cover' => false],

            // Auction ID 7
            ['auction_id' => 7, 'image_path' => 'images/auction7_cover.jpg', 'is_cover' => true],
            ['auction_id' => 7, 'image_path' => 'images/auction7_2.jpg', 'is_cover' => false],

            // Auction ID 8
            ['auction_id' => 8, 'image_path' => 'images/auction8_cover.jpg', 'is_cover' => true],
            ['auction_id' => 8, 'image_path' => 'images/auction8_2.jpg', 'is_cover' => false],

            // Auction ID 9
            ['auction_id' => 9, 'image_path' => 'images/auction9_cover.jpg', 'is_cover' => true],
            ['auction_id' => 9, 'image_path' => 'images/auction9_2.jpg', 'is_cover' => false],

            // Auction ID 10
            ['auction_id' => 10, 'image_path' => 'images/auction10_cover.jpg', 'is_cover' => true],
            ['auction_id' => 10, 'image_path' => 'images/auction10_2.jpg', 'is_cover' => false],
        ]);
    }
}
