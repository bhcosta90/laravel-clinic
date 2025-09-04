<?php

declare(strict_types = 1);

namespace Database\Factories;

use App\Models\Location;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

final class LocationFactory extends Factory
{
    protected $model = Location::class;

    public function definition(): array
    {
        return [
            'tenant_id'  => tenant()?->id ?: DatabaseSeeder::TenantId,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
