<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class AuthTest extends TestCase
{
     use RefreshDatabase;
    /**
     * A basic feature test example.
     */   

    public function test_user_can_register(): void
    {
        $response = $this->postJson('/api/register', [
            'name' => 'Qamar Jamil',
            'email' => 'qamarjamil23@gmail.com',
            'password' => 'Aeiou12#',
            'password_confirmation' => 'Aeiou12#',
        ]);

        $response->assertCreated()->assertJsonStructure(['user', 'token']);
        $this->assertDatabaseHas('users', ['email' => 'qamarjamil23@gmail.com']);
    }

    public function test_user_can_login(): void
    {
        $user = User::factory()->create(['password' => 'Aeiou12#']);

        $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'Aeiou12#',
        ])->assertOk()->assertJsonStructure(['user', 'token']);
    }

    public function test_login_fails_with_wrong_password(): void
    {
        $user = User::factory()->create();

        $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ])->assertUnprocessable()->assertJsonValidationErrors('email');
    }

    public function test_guest_cannot_access_tasks(): void
    {
        $this->getJson('/api/tasks')->assertUnauthorized();
    }
}
