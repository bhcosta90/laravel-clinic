<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Agreement;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

final class AgreementFactory extends Factory
{
    protected $model = Agreement::class;

    public function definition(): array
    {
        return [
            'name'       => $this->faker->sentence(3),
            'cellphone'  => $this->faker->phoneNumber(),
            'commission' => $this->faker->numberBetween(100, 1000) / 100,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
