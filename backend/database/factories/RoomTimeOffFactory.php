<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Room;
use App\Models\RoomTimeOff;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

final class RoomTimeOffFactory extends Factory
{
    protected $model = RoomTimeOff::class;

    public function definition(): array
    {
        return [
            'start_at' => $this->faker->word(),
            'end_at' => $this->faker->word(),
            'reason' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'room_id' => Room::factory(),
        ];
    }
}
