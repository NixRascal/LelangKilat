<?php

namespace Tests\Feature\Api;

use App\Enums\Role;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_list_categories(): void
    {
        Category::factory()->count(3)->create();
        $user = User::factory()->create([
            'password' => bcrypt('password123'),
        ]);

        $token = $user->createToken('test')->plainTextToken;

        $this->withHeader('Authorization', 'Bearer '.$token)
            ->getJson('/api/v1/categories')
            ->assertOk()
            ->assertJsonPath('status', 'success')
            ->assertJsonCount(3, 'data');
    }

    public function test_only_admin_and_staff_can_manage_categories(): void
    {
        $category = Category::factory()->create();
        $user = User::factory()->create([
            'password' => bcrypt('password123'),
        ]);

        $token = $user->createToken('test')->plainTextToken;

        $this->withHeader('Authorization', 'Bearer '.$token)
            ->postJson('/api/v1/categories', [
                'name' => 'Baru',
                'slug' => 'baru',
            ])->assertForbidden();

        $this->withHeader('Authorization', 'Bearer '.$token)
            ->patchJson("/api/v1/categories/{$category->id}", [
                'name' => 'Update',
            ])->assertForbidden();

        $this->withHeader('Authorization', 'Bearer '.$token)
            ->deleteJson("/api/v1/categories/{$category->id}")
            ->assertForbidden();
    }

    public function test_admin_can_crud_categories(): void
    {
        $admin = User::factory()->create([
            'role' => Role::Admin->value,
            'password' => bcrypt('password123'),
        ]);

        $token = $admin->createToken('test')->plainTextToken;

        $createResponse = $this->withHeader('Authorization', 'Bearer '.$token)
            ->postJson('/api/v1/categories', [
                'name' => 'Elektronik',
                'slug' => 'elektronik',
                'icon_path' => 'icons/electronics.svg',
            ])->assertCreated();

        $categoryId = $createResponse->json('data.id');

        $this->withHeader('Authorization', 'Bearer '.$token)
            ->patchJson("/api/v1/categories/{$categoryId}", [
                'name' => 'Elektronik Rumah',
            ])->assertOk()
            ->assertJsonPath('data.name', 'Elektronik Rumah');

        $this->withHeader('Authorization', 'Bearer '.$token)
            ->deleteJson("/api/v1/categories/{$categoryId}")
            ->assertNoContent();
    }
}
