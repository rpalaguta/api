<?php

namespace App\Http\Controllers;

use App\Http\Requests\TimeSlotRequest;
use App\Services\TimeSlotService;

class TimeSlotController extends Controller
{
    protected $timeSlotService;

    public function __construct(TimeSlotService $timeSlotService)
    {
        $this->timeSlotService = $timeSlotService;
    }

    public function store(TimeSlotRequest $request, $psychologist_id)
    {
        $timeSlot = $this->timeSlotService->createTimeSlot($request->validated(), $psychologist_id);
        return response()->json($timeSlot, 201);
    }

    public function index($psychologist_id)
    {
        return $this->timeSlotService->getTimeSlotsForPsychologist($psychologist_id);
    }

    public function update(TimeSlotRequest $request, $id)
    {
        $timeSlot = $this->timeSlotService->updateTimeSlotStatus($id);
        return response()->json($timeSlot);
    }

    public function destroy($id)
    {
        $this->timeSlotService->deleteTimeSlot($id);
        return response()->json(null, 204);
    }
}

