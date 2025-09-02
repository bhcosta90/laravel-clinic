<?php

declare(strict_types = 1);

namespace Database\Factories;

use App\Models\Location;
use App\Models\LocationAddress;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

final class LocationAddressFactory extends Factory
{
    protected $model = LocationAddress::class;

    public function definition(): array
    {
        return [
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'location_id' => Location::factory(),
        ];
    }
}
