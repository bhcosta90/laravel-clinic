<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Remedy;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

final class RemedyFactory extends Factory
{
    protected $model = Remedy::class;

    public function definition(): array
    {
        return [
            'name'        => $this->faker->sentence(2),
            'quantity'    => $this->faker->sentence(3),
            'description' => $this->faker->sentence(3),
            'created_at'  => Carbon::now(),
            'updated_at'  => Carbon::now(),
        ];
    }
}
