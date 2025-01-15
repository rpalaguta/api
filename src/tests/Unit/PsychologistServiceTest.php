<?php

namespace Tests\Unit;

use App\Models\User;
use App\Services\PsychologistService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PsychologistServiceTest extends TestCase
{
    use RefreshDatabase;

    protected $psychologistService;

    public function setUp(): void
    {
        parent::setUp();
        $this->psychologistService = new PsychologistService();
    }

    public function testGetAllPsychologists()
    {
        $psychologist1 = User::factory()->withPsychologistRole()->create();
        $psychologist2 = User::factory()->withPsychologistRole()->create();

        $psychologists = $this->psychologistService->getAllPsychologists();

        $this->assertCount(2, $psychologists);
    }
}

