<?php

namespace App\Services;

use App\Models\Appointment;
use App\Models\TimeSlot;

class AppointmentService
{
    public function bookAppointment(array $data)
    {
        $appointment = Appointment::create($data);
        $appointment->timeSlot->update(['is_booked' => true]);
        return $appointment;
    }

    public function getAllAppointments()
    {
        return Appointment::with('timeSlot.psychologist')->get();
    }
}
