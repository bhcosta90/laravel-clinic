<?php

declare(strict_types = 1);

namespace Database\Factories;

use App\Models\Patient;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

final class PatientFactory extends Factory
{
    protected $model = Patient::class;

    public function definition(): array
    {
        return [
            'code'       => $this->faker->unique()->word(),
            'name'       => $this->faker->name(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }

    public function code(string $code): self
    {
        return $this->state(fn (array $attributes): array => [
            'code' => $code,
        ]);
    }
}
