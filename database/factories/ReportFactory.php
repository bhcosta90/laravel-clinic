<?php

declare(strict_types = 1);

namespace Database\Factories;

use App\Models\Report;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

final class ReportFactory extends Factory
{
    protected $model = Report::class;

    public function definition(): array
    {
        return [
            'tenant_id'  => tenant()?->id ?: DatabaseSeeder::TenantId,
            'key'        => $this->faker->words(),
            'name'       => $this->faker->name(),
            'model_type' => $this->faker->word(),
            'model_id'   => $this->faker->randomNumber(),
            'status'     => $this->faker->randomNumber(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
