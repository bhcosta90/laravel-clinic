<?php

declare(strict_types = 1);

namespace Database\Factories;

use App\Models\LocalAddress;
use App\Models\Location;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

final class LocalAddressFactory extends Factory
{
    protected $model = LocalAddress::class;

    public function definition(): array
    {
        return [
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'location_id' => Location::factory(),
        ];
    }
}
