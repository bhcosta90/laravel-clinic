<?php

declare(strict_types = 1);

namespace Database\Factories;

use App\Models\Packing;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

final class PackingFactory extends Factory
{
    protected $model = Packing::class;

    public function definition(): array
    {
        return [
            'model_type' => $this->faker->word(),
            'model_id'   => $this->faker->word(),
            'level'      => $this->faker->randomNumber(),
            'quantity'   => $this->faker->randomNumber(),
            'weight'     => $this->faker->randomFloat(),
            'length'     => $this->faker->randomFloat(),
            'width'      => $this->faker->randomFloat(),
            'height'     => $this->faker->randomFloat(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
