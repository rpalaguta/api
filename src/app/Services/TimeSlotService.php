<?php

namespace App\Services;

use App\Models\TimeSlot;
use App\Models\User;
use App\Mail\TimeSlotReserved;
use Illuminate\Support\Facades\Mail;

class TimeSlotService
{
    public function createTimeSlot(array $data, $psychologist_id)
    {

        $psychologist = User::find($psychologist_id)->first();

        // Check if there is any existing time slot that overlaps with the new time slot
        $overlappingTimeSlot = $psychologist->timeSlots()
        ->where(function ($query) use ($data) {
            $query->where('start_time', '<', $data['end_time'])
                ->where('end_time', '>', $data['start_time']);
        })
        ->exists();

        // If an overlapping time slot exists, throw an exception or return an error
        if ($overlappingTimeSlot) {
            return response()->json(['error' => 'Time slot overlaps with an existing one'], 400);
        }

        return $psychologist->timeSlots()->create($data);
    }

    public function getTimeSlotsForPsychologist($psychologist_id)
    {
        return User::findOrFail($psychologist_id)->timeSlots;
    }

    public function updateTimeSlotStatus($timeSlotId)
    {
        $timeSlot = TimeSlot::findOrFail($timeSlotId);
        $timeSlot->update(['is_booked' => true]);
        return $timeSlot;
    }

    public function deleteTimeSlot($timeSlotId, $userid): array
    {
        $timeSlot = TimeSlot::where('id', $timeSlotId)->where('psychologist_id', $userid)->first();

        if(!$timeSlot) {
            return ['error' => 'Time slot not found', 'code' => 404];
        }

        $timeSlot->delete();

        return ['error' => null, 'code' => 204];
    }

    public function updateTimeSlot($timeSlotId, array $data)
    {
        // Find the time slot by ID
        $timeSlot = TimeSlot::find($timeSlotId);
        if (!$timeSlot) {
            return ['error' => 'Time slot not found']; // Return as array for error
        }

        // Get the start and end time from the input data
        $newStartTime = $data['start_time'];
        $newEndTime = $data['end_time'];

        // Check for overlapping time slots for the same psychologist
        $overlappingTimeSlot = TimeSlot::where('psychologist_id', $timeSlot->psychologist_id)
            ->where(function ($query) use ($newStartTime, $newEndTime, $timeSlotId) {
                $query->whereBetween('start_time', [$newStartTime, $newEndTime])
                    ->orWhereBetween('end_time', [$newStartTime, $newEndTime])
                    ->orWhere(function ($query) use ($newStartTime, $newEndTime) {
                        $query->where('start_time', '<=', $newStartTime)
                            ->where('end_time', '>=', $newEndTime);
                    });
            })
            ->where('id', '!=', $timeSlotId) // Exclude the current time slot from overlap check
            ->exists();

        if ($overlappingTimeSlot) {
            return ['error' => 'Time slot overlaps with another slot']; // Return as array for error
        }

        // Update the time slot if no overlap
        $timeSlot->update($data);

        // Return the updated time slot
        return $timeSlot;
    }


    public function reserveTimeSlot($timeSlotId, $userid)
    {
        // Find the time slot by its ID
        $timeSlot = TimeSlot::findOrFail($timeSlotId);

        // Check if the time slot already has a client assigned
        if ($timeSlot->client_id) {
            return response()->json(['error' => 'Time slot is already booked'], 400);
        }

        // Update the time slot with the client_id
        $timeSlot->update(['client_id' => $userid]);

        // Send confirmation email (will appear in the logs)
        Mail::to(auth()->user()->email)->send(new TimeSlotReserved($timeSlot));

        // Return the updated time slot directly. Laravel will automatically convert it to JSON.
        return $timeSlot;
    }

    public function getAllAppointments()
    {
        return TimeSlot::all();
    }
}
