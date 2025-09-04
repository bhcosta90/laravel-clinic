<?php

declare(strict_types = 1);

namespace Database\Factories;

use App\Models\Sector;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

final class SectorFactory extends Factory
{
    protected $model = Sector::class;

    public function definition(): array
    {
        return [
            'tenant_id'  => tenant()?->id ?: DatabaseSeeder::TenantId,
            'name'       => $this->faker->unique()->colorName(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
