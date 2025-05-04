<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class WalletSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pastikan user_id 1 dan 2 sudah ada di tabel users
        DB::table('wallets')->insert([
            [
                'user_id' => 1,
                'balance' => 1000000,
                'reserved_balance' => 0,
            ],
            [
                'user_id' => 2,
                'balance' => 500000,
                'reserved_balance' => 0,
            ],
        ]);
    }
}
