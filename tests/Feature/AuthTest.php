<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_a_user_can_register()
    {
        $userData = [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        $response = $this->post('/api/register', $userData);

        $response->assertStatus(201);
        $this->assertDatabaseHas('users', ['email' => $userData['email']]);
    }

    public function testUserLoginWithValidCredentials()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        $loginData = [
            'email' => 'test@example.com',
            'password' => 'password',
        ];

        $response = $this->post('/api/login', $loginData);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'user' => [
                    'id',
                    'name',
                    'email',
                ],
                'token',
            ]);
    }

    public function testUserLoginWithInvalidCredentials()
    {
        $loginData = [
            'email' => 'nonexistent@example.com',
            'password' => 'invalidpassword',
        ];

        $response = $this->post('/api/login', $loginData);

        $response->assertStatus(401)
            ->assertJson([
                'message' => 'Bad credentials',
            ]);
    }

    public function test_a_user_can_logout()
    {
        $user = User::factory()->create();

        $token = $user->createToken('apptoken')->plainTextToken;

        $headers = [
            'Authorization' => 'Bearer ' . $token,
        ];

        $response = $this->withHeaders($headers)->post('/api/logout');

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Logged out.',
            ]);

        // Ensure that the user's token has been deleted from the database
        $this->assertDatabaseMissing('personal_access_tokens', [
            'token' => hash('sha256', $token),
        ]);
    }
}
