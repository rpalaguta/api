<?php

namespace App\Services;

use App\Models\User;

class PsychologistService
{
    public function createPsychologist(array $data)
    {
        return Psychologist::create($data);
    }

    public function getAllPsychologists()
    {
        return User::with('roles')->whereHas('roles', function ($query) {
            $query->where('name', 'psychologist');
        })->get();
    }
}
