<?php

declare(strict_types = 1);

namespace Database\Factories;

use App\Enums\Models\Packing\UnitOfMeasure;
use App\Models\Packing;
use App\Models\Sku;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

final class PackingFactory extends Factory
{
    protected $model = Packing::class;

    public function definition(): array
    {
        $volume = $this->faker->boolean();

        return [
            'unit_of_measure' => $this->faker->randomElements(UnitOfMeasure::cases()),
            'dun14'           => when($this->faker->boolean(), fn () => $this->faker->ean13()),
            'sscc'            => when($this->faker->boolean(), fn () => $this->faker->ean8()),
            'gross_weight'    => when($volume, fn () => $this->faker->randomFloat()),
            'net_weight'      => when($volume, fn () => $this->faker->randomFloat()),
            'volume'          => when($volume, fn () => $this->faker->randomFloat()),
            'created_at'      => Carbon::now(),
            'updated_at'      => Carbon::now(),

            'sku_id' => Sku::factory(),
        ];
    }
}
