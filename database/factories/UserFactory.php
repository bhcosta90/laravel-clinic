<?php

declare(strict_types = 1);

namespace Database\Factories;

use App\Models\Tenant;
use App\Models\Warehouse;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

final class UserFactory extends Factory
{
    private static ?string $password = null;

    public function definition(): array
    {
        return [
            'tenant_id'         => tenant()?->id ?: Tenant::factory(),
            'warehouse_id'      => warehouse()?->id ?: Warehouse::factory(),
            'name'              => fake()->name(),
            'email'             => fake()->unique()->freeEmail(),
            'is_employee'       => fake()->boolean(),
            'email_verified_at' => now(),
            'password'          => self::$password ??= Hash::make('password'),
            'remember_token'    => Str::random(10),
        ];
    }

    public function unverified(): static
    {
        return $this->state(fn (array $attributes): array => [
            'email_verified_at' => null,
        ]);
    }

    public function createTenant(): self
    {
        return $this->state(fn (array $attributes): array => [
            'tenant_id' => Tenant::factory()->create()->id,
        ]);
    }
}
