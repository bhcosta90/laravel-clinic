<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\UserSchedule;
use Core\Domain\Enum\DayEnum;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class UserScheduleFactory extends Factory
{
    protected $model = UserSchedule::class;

    public function definition(): array
    {
        return [
            'day_of_week' => fake()->randomElement(DayEnum::cases()),
            'start_time' => '00:00',
            'end_time' => '01:00',
            'slot_minutes' => fake()->numberBetween(10, 60),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'user_id' => User::factory(),
        ];
    }
}
