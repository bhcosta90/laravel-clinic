<?php

declare(strict_types = 1);

namespace Database\Factories;

use App\Models\Procedure;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

final class ProcedureFactory extends Factory
{
    protected $model = Procedure::class;

    public function definition(): array
    {
        return [
            'code'                 => $this->faker->unique()->word(),
            'name'                 => $this->faker->name(),
            'min_duration_minutes' => $this->faker->randomNumber(),
            'max_duration_minutes' => $this->faker->randomNumber(),
            'created_at'           => Carbon::now(),
            'updated_at'           => Carbon::now(),
        ];
    }
}
