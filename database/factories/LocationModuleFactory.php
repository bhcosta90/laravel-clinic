<?php

declare(strict_types = 1);

namespace Database\Factories;

use App\Models\LocationModule;
use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

final class LocationModuleFactory extends Factory
{
    protected $model = LocationModule::class;

    public function definition(): array
    {
        return [
            'acronym'    => $this->faker->word(),
            'sequence'   => $this->faker->randomNumber(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'tenant_id' => Tenant::factory(),
        ];
    }
}
