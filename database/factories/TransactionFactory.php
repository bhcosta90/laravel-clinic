<?php

declare(strict_types = 1);

namespace Database\Factories;

use App\Enums\Models\Transaction\Type;
use App\Models\Transaction;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

final class TransactionFactory extends Factory
{
    protected $model = Transaction::class;

    public function definition(): array
    {
        return [
            'tenant_id'    => tenant()?->id ?: DatabaseSeeder::TenantId,
            'name'         => $this->faker->sentence(2),
            'value'        => $this->faker->numberBetween(1000, 100000) / 100,
            'due_date'     => $this->faker->dateTimeBetween(now()->addDays(2), now()->addDays(30)),
            'payment_date' => $this->faker->boolean() ? $this->faker->dateTimeBetween(now()->addDays(2), now()->addDays(30)) : null,
            'frequency'    => $this->faker->boolean() ? $this->faker->randomElement([1, 7, 15, 30, 60, 90]) : null,
            'description'  => $this->faker->sentence(3),
            'type'         => $this->faker->randomElement([Type::Expenses, Type::Incomes]),
            'created_at'   => Carbon::now(),
            'updated_at'   => Carbon::now(),
        ];
    }
}
