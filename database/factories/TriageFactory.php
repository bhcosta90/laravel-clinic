<?php

declare(strict_types = 1);

namespace Database\Factories;

use App\Enums\Models\Triage\RiskClassification;
use App\Models\Tenant;
use App\Models\Triage;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

final class TriageFactory extends Factory
{
    protected $model = Triage::class;

    public function definition(): array
    {
        return [
            'tenant_id'           => tenant()?->id ?: Tenant::factory(),
            'risk_classification' => $this->faker->randomElement(RiskClassification::cases()),
            'description'         => $this->faker->sentence(3),
            'mmhg'                => when($this->faker->boolean(), fn () => $this->faker->sentence(2)),
            'bpm'                 => when($this->faker->boolean(), fn () => $this->faker->sentence(2)),
            'irpm'                => when($this->faker->boolean(), fn () => $this->faker->sentence(2)),
            'temperature'         => $this->faker->numberBetween(20, 32),
            'saturation'          => $this->faker->numberBetween(92, 98),
            'allergy'             => when($this->faker->boolean(), fn () => $this->faker->sentence(2)),
            'current_medication'  => when($this->faker->boolean(), fn () => $this->faker->sentence(2)),
            'history_diseases'    => when($this->faker->boolean(), fn () => $this->faker->sentence(2)),
            'time_symptom_onset'  => when($this->faker->boolean(), fn () => $this->faker->sentence(2)),
            'general_condition'   => when($this->faker->boolean(), fn () => $this->faker->sentence(2)),
            'eva'                 => $this->faker->randomNumber(1, 10),
            'created_at'          => Carbon::now(),
            'updated_at'          => Carbon::now(),
        ];
    }
}
