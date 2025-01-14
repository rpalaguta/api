<?php

namespace Database\Factories;

use App\Models\Psychologist;
use Illuminate\Database\Eloquent\Factories\Factory;

class PsychologistFactory extends Factory
{
    protected $model = Psychologist::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
        ];
    }
}

