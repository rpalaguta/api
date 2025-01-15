<?php

namespace Tests\Feature;

use App\Models\Psychologist;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;
use App\Models\User;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function testRegistration()
    {
        // Create a user to authenticate
        $user = User::factory()->create();

        // Act as the authenticated user
        $this->actingAs($user, 'sanctum');

        $data = [
            'name' => 'Dr. Smith',
            'email' => 'dr.smith@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        $response = $this->postJson('/api/register', $data);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'token',
            ]);
    }

}
