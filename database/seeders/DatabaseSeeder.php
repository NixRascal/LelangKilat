<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Seeders\AdSeeder;
use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\WalletSeeder;
use Database\Seeders\AuctionSeeder;
use Database\Seeders\CategorySeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        $this->call([
            AdSeeder::class,
            UserSeeder::class,
            WalletSeeder::class,
            CategorySeeder::class,
            AuctionSeeder::class,
        ]);
    }
}
