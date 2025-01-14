<?php

namespace Tests\Unit;

use App\Models\Psychologist;
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

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_can_create_a_psychologist()
    {
        $data = [
            'name' => 'Dr. Smith',
            'email' => 'dr.smith@example.com',
        ];

        $psychologist = $this->psychologistService->createPsychologist($data);

        $this->assertDatabaseHas('psychologists', [
            'name' => 'Dr. Smith',
            'email' => 'dr.smith@example.com',
        ]);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_can_retrieve_all_psychologists()
    {
        $psychologist1 = Psychologist::factory()->create();
        $psychologist2 = Psychologist::factory()->create();

        $psychologists = $this->psychologistService->getAllPsychologists();

        $this->assertCount(2, $psychologists);
    }
}

