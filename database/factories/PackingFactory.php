<?php

declare(strict_types = 1);

namespace Database\Factories;

use App\Models\Packing;
use App\Models\Sku;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

final class PackingFactory extends Factory
{
    protected $model = Packing::class;

    public function definition(): array
    {
        return [
            'unit_of_measure' => $this->faker->randomNumber(),
            'unit_of_measure' => $this->faker->word(),
            'dun14'           => $this->faker->word(),
            'sscc'            => $this->faker->word(),
            'gross_weight'    => $this->faker->randomFloat(),
            'net_weight'      => $this->faker->randomFloat(),
            'volume'          => $this->faker->randomFloat(),
            'created_at'      => Carbon::now(),
            'updated_at'      => Carbon::now(),

            'sku_id' => Sku::factory(),
        ];
    }
}
