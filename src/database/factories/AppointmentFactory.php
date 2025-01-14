<?php

namespace Database\Factories;

use App\Models\Appointment;
use App\Models\TimeSlot;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factories\Factory;

class AppointmentFactory extends Factory
{
    protected $model = Appointment::class;

    public function definition()
    {
        return [
            'time_slot_id' => TimeSlot::factory(), // Ensure TimeSlot is correctly referenced
            'client_name' => $this->faker->name,
            'client_email' => $this->faker->unique()->safeEmail,
        ];
    }
}

