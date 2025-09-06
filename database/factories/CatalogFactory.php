<?php

declare(strict_types = 1);

namespace Database\Factories;

use App\Enums\Models\Catalog\Hazardous;
use App\Enums\Models\Catalog\Level;
use App\Enums\Models\Catalog\Status;
use App\Enums\Models\Catalog\TrackingMode;
use App\Models\Catalog;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

final class CatalogFactory extends Factory
{
    protected $model = Catalog::class;

    public function definition(): array
    {
        return [
            'name'          => $this->faker->name(),
            'sku_code'      => mb_strtoupper($this->faker->regexify('[A-Za-z0-9]{6}')),
            'level'         => $this->faker->randomElement(Level::cases()),
            'tracking_mode' => $this->faker->randomElement(TrackingMode::cases()),
            'status'        => $this->faker->randomElement(Status::cases()),
            'hazardous'     => $this->faker->randomElement(Hazardous::cases()),
            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now(),
        ];
    }
}
