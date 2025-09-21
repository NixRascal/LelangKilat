<?php

namespace Tests\Feature\Api;

use App\Enums\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthorizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_staff_cannot_access_admin_only_route(): void
    {
        $staff = User::factory()->create([
            'role' => Role::Staff->value,
            'password' => bcrypt('password123'),
        ]);

        $token = $staff->createToken('test')->plainTextToken;

        $this->withHeader('Authorization', 'Bearer '.$token)
            ->getJson('/api/v1/audit-logs')
            ->assertForbidden();
    }
}
