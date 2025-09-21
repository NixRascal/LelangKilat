<?php

namespace Tests\Feature\Api;

use App\Enums\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register_and_login(): void
    {
        $response = $this->postJson('/api/v1/auth/register', [
            'name' => 'Tester',
            'email' => 'tester@example.com',
            'password' => 'password123',
        ]);

        $response->assertCreated()->assertJsonPath('data.user.email', 'tester@example.com');

        $login = $this->postJson('/api/v1/auth/login', [
            'email' => 'tester@example.com',
            'password' => 'password123',
        ]);

        $login->assertOk()->assertJsonPath('data.user.name', 'Tester');
    }

    public function test_refresh_token_invalidates_old_session(): void
    {
        $user = User::factory()->create([
            'email' => 'refresh@example.com',
            'password' => bcrypt('password123'),
        ]);

        $login = $this->postJson('/api/v1/auth/login', [
            'email' => 'refresh@example.com',
            'password' => 'password123',
        ])->assertOk();

        $token = $login->json('data.token');
        $refresh = $login->json('data.refresh_token');

        $refreshResponse = $this->withHeader('Authorization', 'Bearer '.$token)
            ->postJson('/api/v1/auth/refresh', ['refresh_token' => $refresh])
            ->assertOk();

        $this->withHeader('Authorization', 'Bearer '.$token)
            ->getJson('/api/v1/dashboard')
            ->assertUnauthorized();

        $newToken = $refreshResponse->json('data.token');
        $this->withHeader('Authorization', 'Bearer '.$newToken)
            ->getJson('/api/v1/dashboard')
            ->assertOk();
    }
}
