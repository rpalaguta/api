<?php

namespace App\Services;

use App\Models\Psychologist;
use App\Models\TimeSlot;

class TimeSlotService
{
    public function createTimeSlot(array $data, $psychologist_id)
    {
        $psychologist = Psychologist::findOrFail($psychologist_id);
        return $psychologist->timeSlots()->create($data);
    }

    public function getTimeSlotsForPsychologist($psychologist_id)
    {
        return Psychologist::findOrFail($psychologist_id)->timeSlots;
    }

    public function updateTimeSlotStatus($timeSlotId)
    {
        $timeSlot = TimeSlot::findOrFail($timeSlotId);
        $timeSlot->update(['is_booked' => true]);
        return $timeSlot;
    }

    public function deleteTimeSlot($timeSlotId)
    {
        $timeSlot = TimeSlot::findOrFail($timeSlotId);
        $timeSlot->delete();
        return $timeSlot;
    }
}
