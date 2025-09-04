<?php

declare(strict_types = 1);

namespace Database\Factories;

use App\Models\Room;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

final class RoomFactory extends Factory
{
    protected $model = Room::class;

    public function definition(): array
    {
        return [
            'tenant_id'  => tenant()?->id ?: DatabaseSeeder::TenantId,
            'name'       => $this->faker->sentence(3),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
