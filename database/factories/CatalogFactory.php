<?php

declare(strict_types = 1);

namespace Database\Factories;

use App\Enums\Models\Catalog\Hazardous;
use App\Enums\Models\Catalog\Status;
use App\Enums\Models\Catalog\TrackingMode;
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
            'tenant_id'     => tenant()?->id ?: Tenant::factory(),
            'name'          => $this->faker->name(),
            'tracking_mode' => $this->faker->randomElement(TrackingMode::cases()),
            'hazardous'     => $this->faker->randomElement(Hazardous::cases()),
            'status'        => Status::Enabled,
            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now(),
        ];
    }
}
