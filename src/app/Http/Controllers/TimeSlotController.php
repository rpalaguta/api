<?php

namespace App\Http\Controllers;

use App\Http\Requests\TimeSlotRequest;
use App\Services\TimeSlotService;
use Illuminate\Support\Facades\Auth;
use App\Models\TimeSlot;

class TimeSlotController extends Controller
{
    protected $timeSlotService;

    public function __construct(TimeSlotService $timeSlotService)
    {
        $this->timeSlotService = $timeSlotService;
    }

    public function store(TimeSlotRequest $request, $psychologist_id)
    {
        // Check if user is logged in and has role_id 2
        $user = Auth::user();
        if (!$user || !$user->roles()->where('role_id', 2)->exists()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Ensure the user is trying to manage their own time slots
        if ($user->id != $psychologist_id) {
            return response()->json(['error' => 'Unauthorized to manage this psychologist\'s time slots'], 403);
        }

        $timeSlot = $this->timeSlotService->createTimeSlot($request->validated(), $psychologist_id);
        return $timeSlot;
    }

    public function listAppointments()
    {
        return response()->json($this->timeSlotService->getAllAppointments());
    }

    public function index($psychologist_id)
    {
        return response()->json($this->timeSlotService->getTimeSlotsForPsychologist($psychologist_id));
    }

    public function update(TimeSlotRequest $request, $id)
    {
        // Check if user is logged in and has role_id 2
        $user = Auth::user();
        if (!$user || !$user->roles()->where('role_id', 2)->exists()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Ensure the user is trying to update their own time slot
        $timeSlot = TimeSlot::findOrFail($id);
        if ($timeSlot->psychologist_id != $user->id) {
            return response()->json(['error' => 'Unauthorized to update this time slot'], 403);
        }

        $timeSlot = $this->timeSlotService->updateTimeSlot($id, $request->validated());
        return response()->json($timeSlot);
    }

    public function destroy($psychologist_id, $time_slot_id)
    {
        // Check if user is logged in and has role_id 2
        $user = Auth::user();
        if (!$user || $user->id != $psychologist_id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $result = $this->timeSlotService->deleteTimeSlot($time_slot_id, $user->id);

        if ($result['error']) {
            return response()->json(['error' => $result['error']], $result['code']);
        }
        return response()->json(null, $result['code']);
    }

    public function reserve($time_slot_id)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Call the service method to reserve the time slot
        $timeSlot = $this->timeSlotService->reserveTimeSlot($time_slot_id, $user->id);

        return $timeSlot;  // Return the time slot directly as it will be automatically JSON-encoded
    }
}

