<?php
// filepath: /c:/Users/rpala/Desktop/Darbas/Užduotys/api/src/tests/Unit/TimeSlotServiceTest.php
namespace Tests\Unit;

use Tests\TestCase;
use App\Services\TimeSlotService;
use App\Models\User;
use App\Models\TimeSlot;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TimeSlotServiceTest extends TestCase
{
    use RefreshDatabase;

    protected $timeSlotService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->timeSlotService = new TimeSlotService();
    }

    public function testCreateTimeSlot()
    {
        $psychologist = User::factory()->create();
        $data = [
            'start_time' => '2023-10-01 10:00:00',
            'end_time' => '2023-10-01 11:00:00',
            'psychologist_id' => $psychologist->id,
        ];

        $response = $this->timeSlotService->createTimeSlot($data, $psychologist->id);

        $this->assertDatabaseHas('time_slots', $data);
        $this->assertEquals($response->psychologist_id, $psychologist->id);
    }

    public function testGetTimeSlotsForPsychologist()
    {
        $psychologist = User::factory()->create();
        $timeSlot = TimeSlot::factory()->create(['psychologist_id' => $psychologist->id]);

        $timeSlots = $this->timeSlotService->getTimeSlotsForPsychologist($psychologist->id);

        $this->assertCount(1, $timeSlots);
        $this->assertEquals($timeSlot->id, $timeSlots->first()->id);
    }

    public function testDeleteTimeSlot()
    {
        $psychologist = User::factory()->create();
        $timeSlot = TimeSlot::factory()->create(['psychologist_id' => $psychologist->id]);

        $response = $this->timeSlotService->deleteTimeSlot($timeSlot->id, $psychologist->id);

        $this->assertEquals(204, $response['code']);
        $this->assertDatabaseMissing('time_slots', ['id' => $timeSlot->id]);
    }

    public function testUpdateTimeSlot()
    {
        $timeSlot = TimeSlot::factory()->create();
        $data = [
            'start_time' => '2023-10-01 12:00:00',
            'end_time' => '2023-10-01 13:00:00',
        ];

        $response = $this->timeSlotService->updateTimeSlot($timeSlot->id, $data);

        $this->assertNull($response['error']);
        $this->assertDatabaseHas('time_slots', $data);
    }

    public function testUpdateTimeSlotWithOverlappingTimeSlot()
    {
        $psychologist = User::factory()->create();

        TimeSlot::factory()->create([
            'psychologist_id' => $psychologist->id,
            'start_time' => '2025-01-15 10:00:00',
            'end_time' => '2025-01-15 11:00:00',
        ]);

        $timeSlot = TimeSlot::factory()->create([
            'psychologist_id' => $psychologist->id,
            'start_time' => '2025-01-15 11:00:00',
            'end_time' => '2025-01-15 12:00:00',
        ]);


        $data = [
            'start_time' => '2025-01-15 10:30:00',
            'end_time' => '2025-01-15 11:03:00',
        ];

        $response = $this->timeSlotService->updateTimeSlot($timeSlot->id, $data);

        $this->assertEquals(['error' => 'Time slot overlaps with another slot'], $response);
    }

    public function testReserveAnAppointment()
    {
        $user = User::factory()->create();

        // Log the user in using Sanctum
        $this->actingAs($user, 'sanctum');

        $timeSlot = TimeSlot::factory()->create([
            'psychologist_id' => $user->id,  // Ensure the time slot is linked to the psychologist
            'client_id' => null,
        ]);

        $appointment = $this->timeSlotService->reserveTimeSlot($timeSlot->id, $user->id);

        $this->assertDatabaseHas('time_slots', [
            'id' => $timeSlot->id,
            'client_id' => $user->id,
        ]);
    }
}
