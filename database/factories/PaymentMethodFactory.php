<?php

declare(strict_types = 1);

namespace Database\Factories;

use App\Models\PaymentMethod;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

final class PaymentMethodFactory extends Factory
{
    protected $model = PaymentMethod::class;

    public function definition(): array
    {
        return [
            'tenant_id'  => tenant()?->id ?: DatabaseSeeder::TenantId,
            'name'       => $this->faker->name(),
            'tax'        => $this->faker->numberBetween(100, 10000) / 100,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
