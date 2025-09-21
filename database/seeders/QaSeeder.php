<?php

namespace Database\Seeders;

use App\Enums\Role;
use App\Models\Auction;
use App\Models\Bid;
use App\Models\Category;
use App\Models\User;
use App\Models\Wallet;
use App\Models\WalletTransaction;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

class QaSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::factory()->create([
            'name' => 'Admin QA',
            'email' => 'admin@qa.test',
            'password' => Hash::make('password123'),
            'role' => Role::Admin->value,
        ]);

        $staff = User::factory()->create([
            'name' => 'Staff QA',
            'email' => 'staff@qa.test',
            'password' => Hash::make('password123'),
            'role' => Role::Staff->value,
        ]);

        $users = User::factory(8)->create([
            'password' => Hash::make('password123'),
            'role' => Role::User->value,
        ])->push($admin, $staff);

        Category::factory()->count(5)->sequence(
            ['name' => 'Elektronik', 'slug' => 'elektronik', 'icon_path' => 'icons/electronics.svg'],
            ['name' => 'Fashion', 'slug' => 'fashion', 'icon_path' => 'icons/fashion.svg'],
            ['name' => 'Rumah Tangga', 'slug' => 'rumah-tangga', 'icon_path' => 'icons/home.svg'],
            ['name' => 'Hobi', 'slug' => 'hobi', 'icon_path' => 'icons/hobby.svg'],
            ['name' => 'Koleksi', 'slug' => 'koleksi', 'icon_path' => 'icons/collection.svg'],
        )->create();

        $auctions = Auction::factory()->count(10)->create();

        $auctions->each(function (Auction $auction) use ($users) {
            $participants = $users->shuffle()->take(3);
            $bidAmount = $auction->starting_bid;

            foreach ($participants as $participant) {
                $bidAmount += random_int(10000, 50000);
                Bid::create([
                    'auction_id' => $auction->id,
                    'user_id' => $participant->id,
                    'amount' => $bidAmount,
                ]);
            }

            $auction->update([
                'current_bid' => $bidAmount,
                'highest_bidder_id' => $participants->last()->id,
                'status' => 'active',
            ]);
        });

        $users->each(function (User $user) {
            $wallet = $user->wallet()->create([
                'balance' => 500000,
                'reserved_balance' => 0,
            ]);

            WalletTransaction::create([
                'wallet_id' => $wallet->id,
                'type' => 'CREDIT',
                'amount' => 500000,
                'description' => 'Saldo awal QA',
            ]);
        });

        // End to end scenarios
        $this->seedScenarios($users);
    }

    private function seedScenarios($users): void
    {
        $creator = $users->first();
        $auction = Auction::factory()->create([
            'user_id' => $creator->id,
            'status' => 'active',
            'starting_bid' => 100000,
            'current_bid' => 100000,
        ]);

        $bidder = $users->get(1);
        Bid::create([
            'auction_id' => $auction->id,
            'user_id' => $bidder->id,
            'amount' => 120000,
        ]);

        $auction->update([
            'current_bid' => 120000,
            'highest_bidder_id' => $bidder->id,
        ]);

        // Skenario gagal: bid lebih rendah
        Bid::create([
            'auction_id' => $auction->id,
            'user_id' => $users->get(2)->id,
            'amount' => 1000,
        ]);
    }
}
