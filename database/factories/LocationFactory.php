<?php

declare(strict_types = 1);

namespace Database\Factories;

use App\Models\Location;
use App\Models\Tenant;
use App\Models\Warehouse;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

final class LocationFactory extends Factory
{
    protected $model = Location::class;

    public function definition(): array
    {
        return [
            'tenant_id'    => tenant()?->id ?: Tenant::factory(),
            'warehouse_id' => warehouse()?->id ?: Warehouse::factory(),
            'created_at'   => Carbon::now(),
            'updated_at'   => Carbon::now(),
        ];
    }
}
