<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_login_and_receive_jwt_token()
    {
        // Arrange: Buat user dummy
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
            'role' => 'customer',
        ]);

        // Act: Kirim request login
        $response = $this->postJson('/api/auth/login', [
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        // Debug: Jika gagal bisa lihat responsenya
        $response->dump();

        // Assert: Harus dapat token
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'access_token',
            'token_type',
            'expires_in',
            'user' => ['id', 'name', 'email', 'role']
        ]);
    }

    public function test_login_fails_with_invalid_credentials()
    {
        // Arrange
        $user = User::factory()->create([
            'email' => 'wrong@example.com',
            'password' => bcrypt('secret'),
        ]);

        // Act
        $response = $this->postJson('/api/auth/login', [
            'email' => 'wrong@example.com',
            'password' => 'invalid',
        ]);

        // Debug responsenya
        $response->dump();

        // Assert: Gagal login
        $response->assertStatus(401);
        $response->assertJson([
            'error' => 'Unauthorized',
        ]);
    }
}
