<?php

namespace App\Services;

use App\Models\Psychologist;

class PsychologistService
{
    public function createPsychologist(array $data)
    {
        return Psychologist::create($data);
    }

    public function getAllPsychologists()
    {
        return Psychologist::all();
    }
}
