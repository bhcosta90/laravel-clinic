<?php

declare(strict_types = 1);

namespace Database\Factories;

use App\Models\Frequency;
use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

final class FrequencyFactory extends Factory
{
    protected $model = Frequency::class;

    public function definition(): array
    {
        return [
            'tenant_id'  => tenant()?->id ?: Tenant::factory(),
            'name'       => $this->faker->name(),
            'days'       => $this->faker->randomElement([30, 60, 90, 120]),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
