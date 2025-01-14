<?php

namespace App\Http\Controllers;

use App\Http\Requests\PsychologistRequest;
use App\Services\PsychologistService;

class PsychologistController extends Controller
{
    protected $psychologistService;

    public function __construct(PsychologistService $psychologistService)
    {
        $this->psychologistService = $psychologistService;
    }

    public function store(PsychologistRequest $request)
    {
        $psychologist = $this->psychologistService->createPsychologist($request->validated());
        return response()->json($psychologist, 201);
    }

    public function index()
    {
        return $this->psychologistService->getAllPsychologists();
    }
}
