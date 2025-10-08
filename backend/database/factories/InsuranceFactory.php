<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Insurance;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

final class InsuranceFactory extends Factory
{
    protected $model = Insurance::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'min_days_in_advance' => fake()->boolean() ? $this->faker->numberBetween(1, 10) : null,
            'max_monthly_appointments' => fake()->boolean() ? $this->faker->numberBetween(1, 10) : null,
            'max_total_appointments' => fake()->boolean() ? $this->faker->numberBetween(1, 10) : null,
            'allowed_weekdays' => [],
            'max_appointments_per_patient_month' => fake()->boolean() ? $this->faker->numberBetween(1, 3) : null,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
