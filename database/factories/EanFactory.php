<?php

declare(strict_types = 1);

namespace Database\Factories;

use App\Enums\Models\Ean\UnitOfMeasure;
use App\Models\Ean;
use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

final class EanFactory extends Factory
{
    protected $model = Ean::class;

    public function definition(): array
    {
        return [
            'tenant_id'       => tenant()?->id ?: Tenant::factory(),
            'unit_of_measure' => $this->faker->randomElement(UnitOfMeasure::cases()),
            'ean'             => $this->faker->unique()->ean13(),
            'created_at'      => Carbon::now(),
            'updated_at'      => Carbon::now(),
        ];
    }
}
