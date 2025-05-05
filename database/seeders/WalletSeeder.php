<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WalletSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('wallets')->insert([
            [
                'user_id' => 1,
                'balance' => 1000000,
                'reserved_balance' => 500000,
                'created_at' => now(),
            ],
            [
                'user_id' => 2,
                'balance' => 500000,
                'reserved_balance' => 0,
                'created_at' => now(),
            ],
            [
                'user_id' => 3,
                'balance' => 750000,
                'reserved_balance' => 0,
                'created_at' => now(),
            ],
            [
                'user_id' => 4,
                'balance' => 1200000,
                'reserved_balance' => 0,
                'created_at' => now(),
            ],
            [
                'user_id' => 5,
                'balance' => 650000,
                'reserved_balance' => 0,
                'created_at' => now(),
            ],
            [
                'user_id' => 6,
                'balance' => 300000,
                'reserved_balance' => 0,
                'created_at' => now(),
            ],
            [
                'user_id' => 7,
                'balance' => 900000,
                'reserved_balance' => 0,
                'created_at' => now(),
            ],
            [
                'user_id' => 8,
                'balance' => 450_000,
                'reserved_balance' => 0,
                'created_at' => now(),
            ],
            [
                'user_id' => 9,
                'balance' => 600000,
                'reserved_balance' => 0,
                'created_at' => now(),
            ],
            [
                'user_id' => 10,
                'balance' => 800000,
                'reserved_balance' => 0,
                'created_at' => now(),
            ],
        ]);
    }
}
