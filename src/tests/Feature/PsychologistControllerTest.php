<?php

namespace Tests\Feature;

use App\Models\Psychologist;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class PsychologistControllerTest extends TestCase
{
    use RefreshDatabase;

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_can_create_a_psychologist()
    {
        // Create a user to authenticate
        $user = User::factory()->create();

        // Act as the authenticated user
        $this->actingAs($user, 'sanctum');

        $data = [
            'name' => 'Dr. Smith',
            'email' => 'dr.smith@example.com',
        ];

        $response = $this->postJson('/api/psychologists', $data);

        $response->assertStatus(201)
                ->assertJson([
                    'name' => 'Dr. Smith',
                    'email' => 'dr.smith@example.com',
                ]);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_can_list_psychologists()
    {
        $psychologist = Psychologist::factory()->create();

        $response = $this->getJson('/api/psychologists');

        $response->assertStatus(200)
                 ->assertJsonFragment(['name' => $psychologist->name]);
    }
}
