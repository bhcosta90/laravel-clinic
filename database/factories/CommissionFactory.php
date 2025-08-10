<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Commission;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

final class CommissionFactory extends Factory
{
    protected $model = Commission::class;

    public function definition(): array
    {
        return [
            'value'      => $this->faker->numberBetween(1000, 10000) / 100,
            'due_date'   => $this->faker->dateTimeBetween(now()->addDays(2), now()->addDays(30)),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
