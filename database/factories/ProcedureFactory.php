<?php

declare(strict_types = 1);

namespace Database\Factories;

use App\Models\Procedure;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

final class ProcedureFactory extends Factory
{
    protected $model = Procedure::class;

    public function definition(): array
    {
        return [
            'tenant_id'    => tenant()?->id ?: DatabaseSeeder::TenantId,
            'name'         => $this->faker->sentence(2),
            'price'        => $this->faker->numberBetween(10000, 100000) / 100,
            'time'         => $this->faker->randomNumber(),
            'description'  => $this->faker->sentence(3),
            'is_agreement' => $this->faker->boolean(),
            'is_exam'      => $this->faker->boolean(),
            'created_at'   => Carbon::now(),
            'updated_at'   => Carbon::now(),
        ];
    }
}
