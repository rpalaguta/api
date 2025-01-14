<?php

namespace App\Http\Controllers;

use App\Http\Requests\AppointmentRequest;
use App\Services\AppointmentService;

class AppointmentController extends Controller
{
    protected $appointmentService;

    public function __construct(AppointmentService $appointmentService)
    {
        $this->appointmentService = $appointmentService;
    }

    public function store(AppointmentRequest $request)
    {
        $appointment = $this->appointmentService->bookAppointment($request->validated());
        return response()->json($appointment, 201);
    }

    public function index()
    {
        return $this->appointmentService->getAllAppointments();
    }
}
