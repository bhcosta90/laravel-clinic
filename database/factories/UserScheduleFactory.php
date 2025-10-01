<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\UserSchedule;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class UserScheduleFactory extends Factory
{
    protected $model = UserSchedule::class;

    public function definition(): array
    {
        return [
            'day_of_week' => $this->faker->word(),
            'start_time' => Carbon::now(),
            'end_time' => Carbon::now(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'user_id' => User::factory(),
        ];
    }
}
