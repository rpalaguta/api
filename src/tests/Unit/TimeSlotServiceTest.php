<?php

namespace Tests\Unit;

use App\Models\Psychologist;
use App\Models\TimeSlot;
use App\Services\TimeSlotService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TimeSlotServiceTest extends TestCase
{
    use RefreshDatabase;

    protected $timeSlotService;

    public function setUp(): void
    {
        parent::setUp();
        $this->timeSlotService = new TimeSlotService();
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_can_create_time_slot_for_psychologist()
    {
        $psychologist = Psychologist::factory()->create();
        $data = [
            'start_time' => now()->addHour(),
            'end_time' => now()->addHour(2),
        ];

        $timeSlot = $this->timeSlotService->createTimeSlot($data, $psychologist->id);

        $this->assertDatabaseHas('time_slots', [
            'psychologist_id' => $psychologist->id,
            'start_time' => $data['start_time'],
            'end_time' => $data['end_time'],
        ]);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_can_retrieve_time_slots_for_psychologist()
    {
        $psychologist = Psychologist::factory()->create();
        TimeSlot::factory()->create(['psychologist_id' => $psychologist->id]);

        $timeSlots = $this->timeSlotService->getTimeSlotsForPsychologist($psychologist->id);

        $this->assertCount(1, $timeSlots);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_can_update_time_slot_status_to_booked()
    {
        $timeSlot = TimeSlot::factory()->create(['is_booked' => false]);

        $updatedTimeSlot = $this->timeSlotService->updateTimeSlotStatus($timeSlot->id);

        $this->assertTrue($updatedTimeSlot->is_booked);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_can_delete_time_slot()
    {
        // Create a time slot
        $timeSlot = TimeSlot::factory()->create();

        // Delete the time slot
        $this->timeSlotService->deleteTimeSlot($timeSlot->id);

        // Assert that the time slot has been deleted
        $this->assertDatabaseMissing('time_slots', [
            'id' => $timeSlot->id,
        ]);
    }
}

