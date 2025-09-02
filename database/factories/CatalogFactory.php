<?php

declare(strict_types = 1);

namespace Database\Factories;

use App\Models\Catalog;
use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

final class CatalogFactory extends Factory
{
    protected $model = Catalog::class;

    public function definition(): array
    {
        return [
            'name'                   => $this->faker->name(),
            'tracking_mode'          => $this->faker->randomNumber(),
            'hazardous'              => $this->faker->randomNumber(),
            'temperature_controlled' => $this->faker->randomNumber(),
            'status'                 => $this->faker->randomNumber(),
            'created_at'             => Carbon::now(),
            'updated_at'             => Carbon::now(),

            'tenant_id' => Tenant::factory(),
        ];
    }
}
