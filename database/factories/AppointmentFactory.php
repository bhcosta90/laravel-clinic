<?php

declare(strict_types = 1);

namespace Database\Factories;

use App\Models\Appointment;
use App\Models\Customer;
use App\Models\Procedure;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

final class AppointmentFactory extends Factory
{
    protected $model = Appointment::class;

    public function definition(): array
    {
        return [
            'tenant_id'            => DatabaseSeeder::TenantId,
            'customer_id'          => Customer::factory(),
            'procedure_id'         => Procedure::factory(),
            'date'                 => $this->faker->dateTimeBetween(now()->firstOfMonth(), now()->endOfMonth()),
            'is_return'            => $this->faker->boolean(),
            'exam_withdrawal_date' => $this->faker->sentence(2),
            'description'          => $this->faker->sentence(3),
            'created_at'           => Carbon::now(),
            'updated_at'           => Carbon::now(),
        ];
    }
}
