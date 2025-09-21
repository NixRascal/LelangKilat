<?php

namespace Tests\Feature\Api;

use App\Enums\Role;
use App\Models\Auction;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuctionTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_list_and_create_auctions(): void
    {
        $category = Category::factory()->create();
        $admin = User::factory()->create([
            'role' => Role::Admin->value,
            'password' => bcrypt('password123'),
        ]);

        $token = $admin->createToken('test')->plainTextToken;

        $this->withHeader('Authorization', 'Bearer '.$token)
            ->getJson('/api/v1/auctions')
            ->assertOk();

        $payload = [
            'title' => 'Laptop Gaming',
            'description' => 'Laptop mulus',
            'starting_bid' => 2000000,
            'start_time' => now()->addHour()->toIso8601String(),
            'end_time' => now()->addHours(2)->toIso8601String(),
            'status' => 'active',
            'category_id' => $category->id,
        ];

        $this->withHeader('Authorization', 'Bearer '.$token)
            ->postJson('/api/v1/auctions', $payload)
            ->assertCreated();
    }

    public function test_bid_must_be_higher_than_current(): void
    {
        $category = Category::factory()->create();
        $user = User::factory()->create([
            'role' => Role::User->value,
            'password' => bcrypt('password123'),
        ]);

        $user->wallet()->create([
            'balance' => 500000,
            'reserved_balance' => 0,
        ]);

        $auction = Auction::factory()->create([
            'category_id' => $category->id,
            'current_bid' => 200000,
            'status' => 'active',
        ]);

        $token = $user->createToken('test')->plainTextToken;

        $this->withHeader('Authorization', 'Bearer '.$token)
            ->postJson("/api/v1/auctions/{$auction->id}/bids", ['amount' => 150000])
            ->assertStatus(422);
    }

    public function test_user_cannot_bid_without_sufficient_wallet_balance(): void
    {
        $category = Category::factory()->create();
        $user = User::factory()->create([
            'role' => Role::User->value,
            'password' => bcrypt('password123'),
        ]);

        $user->wallet()->create([
            'balance' => 50000,
            'reserved_balance' => 0,
        ]);

        $auction = Auction::factory()->create([
            'category_id' => $category->id,
            'current_bid' => 100000,
            'status' => 'active',
        ]);

        $token = $user->createToken('test')->plainTextToken;

        $this->withHeader('Authorization', 'Bearer '.$token)
            ->postJson("/api/v1/auctions/{$auction->id}/bids", ['amount' => 120000])
            ->assertStatus(422)
            ->assertJsonPath('message', 'Saldo dompet tidak mencukupi');
    }
}
