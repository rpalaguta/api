<?php

namespace Tests\Feature;

use App\Models\Psychologist;
use App\Models\TimeSlot;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TimeSlotControllerTest extends TestCase
{
    use RefreshDatabase;

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_can_create_a_time_slot()
    {
        $psychologist = Psychologist::factory()->create();
        $data = [
            'start_time' => now()->addHour(),
            'end_time' => now()->addHour(2),
        ];

        $response = $this->postJson("/api/psychologists/{$psychologist->id}/time-slots", $data);

        $response->assertStatus(201)
                 ->assertJson($data);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_can_update_time_slot_status_to_booked()
    {
        $timeSlot = TimeSlot::factory()->create(['is_booked' => false]);

        $response = $this->putJson("/api/time-slots/{$timeSlot->id}", ['is_booked' => true]);

        $response->assertStatus(200)
                 ->assertJson(['is_booked' => true]);
    }
}
