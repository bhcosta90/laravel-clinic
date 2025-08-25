<?php

declare(strict_types = 1);

namespace Database\Factories;

use App\Models\Customer;
use App\Models\Triage;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

final class TriageFactory extends Factory
{
    protected $model = Triage::class;

    public function definition(): array
    {
        return [
            'risk'               => $this->faker->randomNumber(),
            'description'        => $this->faker->text(),
            'mmhg'               => $this->faker->word(),
            'bpm'                => $this->faker->word(),
            'irpm'               => $this->faker->word(),
            'temperature'        => $this->faker->randomNumber(),
            'saturation'         => $this->faker->randomNumber(),
            'allergies'          => $this->faker->word(),
            'current_medication' => $this->faker->word(),
            'history_diseases'   => $this->faker->word(),
            'time_symptom_onset' => $this->faker->word(),
            'general_condition'  => $this->faker->word(),
            'eva'                => $this->faker->randomNumber(),
            'created_at'         => Carbon::now(),
            'updated_at'         => Carbon::now(),

            'customer_id' => Customer::factory(),
        ];
    }
}
