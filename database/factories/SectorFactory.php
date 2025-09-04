<?php

declare(strict_types = 1);

namespace Database\Factories;

use App\Models\Sector;
use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

final class SectorFactory extends Factory
{
    protected $model = Sector::class;

    public function definition(): array
    {
        return [
            'tenant_id'  => tenant()?->id ?: Tenant::factory(),
            'name'       => $this->faker->unique()->colorName(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
