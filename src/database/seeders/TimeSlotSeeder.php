<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TimeSlot;

class TimeSlotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TimeSlot::upsert([
            [
                'psychologist_id' => 2,
                'start_time' => '2025-01-15 09:00:00',
                'end_time' => '2025-01-15 10:00:00',
                'created_at' => now(),
            ],
            [
                'psychologist_id' => 2,
                'start_time' => '2025-01-15 10:00:00',
                'end_time' => '2025-01-15 11:00:00',
                'created_at' => now(),
            ],
            [
                'psychologist_id' => 2,
                'start_time' => '2025-01-15 11:00:00',
                'end_time' => '2025-01-15 12:00:00',
                'created_at' => now(),
            ],
            [
                'psychologist_id' => 2,
                'start_time' => '2025-01-15 12:00:00',
                'end_time' => '2025-01-15 13:00:00',
                'created_at' => now(),
            ],
        ], ['psychologist_id', 'start_time', 'end_time']);
    }
}
