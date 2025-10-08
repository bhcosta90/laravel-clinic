<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Doctor;
use App\Models\DoctorTimeOff;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

final class DoctorTimeOffFactory extends Factory
{
    protected $model = DoctorTimeOff::class;

    public function definition(): array
    {
        return [
            'start_at' => Carbon::now(),
            'end_at' => Carbon::now(),
            'reason' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'doctor_id' => Doctor::factory(),
        ];
    }
}
