<?php

namespace Tests\Unit;

use App\Models\Appointment;
use App\Models\TimeSlot;
use App\Services\AppointmentService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Psychologist;
use Tests\TestCase;

class AppointmentServiceTest extends TestCase
{
    use RefreshDatabase;

    protected $appointmentService;

    public function setUp(): void
    {
        parent::setUp();
        $this->appointmentService = new AppointmentService();
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_can_book_appointment()
    {
        $psychologist = Psychologist::factory()->create();  // Ensure a psychologist exists

        $timeSlot = TimeSlot::factory()->create([
            'psychologist_id' => $psychologist->id,  // Ensure the time slot is linked to the psychologist
            'is_booked' => false,
        ]);

        $data = [
            'time_slot_id' => $timeSlot->id,
            'client_name' => 'John Doe',
            'client_email' => 'john@example.com',
        ];

        $appointment = $this->appointmentService->bookAppointment($data);

        $this->assertDatabaseHas('appointments', [
            'time_slot_id' => $timeSlot->id,
            'client_name' => 'John Doe',
            'client_email' => 'john@example.com',
        ]);

        $this->assertTrue($timeSlot->fresh()->is_booked);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_can_retrieve_all_appointments()
    {
        $appointment = Appointment::factory()->create();

        $appointments = $this->appointmentService->getAllAppointments();

        $this->assertCount(1, $appointments);
    }
}

