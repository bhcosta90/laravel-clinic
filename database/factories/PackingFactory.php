<?php

declare(strict_types = 1);

namespace Database\Factories;

use App\Enums\Models\Packing\UnitOfMeasure;
use App\Models\Packing;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

final class PackingFactory extends Factory
{
    protected $model = Packing::class;

    public function definition(): array
    {
        $volume = $this->faker->boolean();

        return [
            'unit_of_measure' => $this->faker->randomElement(UnitOfMeasure::cases()),
            'dun14'           => when($this->faker->boolean(), fn () => $this->faker->unique()->ean13()),
            'sscc'            => when($this->faker->boolean(), fn () => $this->faker->unique()->ean8()),
            'gross_weight'    => when($volume, fn (): int | float => $this->faker->numberBetween(1000, 100000) / 100),
            'net_weight'      => when($volume, fn (): int | float => $this->faker->numberBetween(1000, 100000) / 100),
            'volume'          => when($volume, fn (): int | float => $this->faker->numberBetween(1000, 100000) / 100),
            'created_at'      => Carbon::now(),
            'updated_at'      => Carbon::now(),
        ];
    }
}
