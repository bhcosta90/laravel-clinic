<?php

declare(strict_types = 1);

namespace Database\Factories;

use App\Models\Specialty;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

final class UserFactory extends Factory
{
    private static ?string $password = null;

    public function definition(): array
    {
        return [
            'name'              => fake()->name(),
            'email'             => fake()->unique()->freeEmail(),
            'email_verified_at' => now(),
            'password'          => self::$password ??= Hash::make('password'),
            'remember_token'    => Str::random(10),
        ];
    }

    public function doctor(): self
    {
        return $this->state(fn (array $attributes): array => [
            'is_doctor' => true,
        ]);
    }

    public function hasFixedHours(): self
    {
        return $this->state(fn (array $attributes): array => [
            'has_fixed_hours' => true,
        ]);
    }

    public function specialty(?Specialty $spec = null): self
    {
        return $this->afterCreating(function (User $user) use ($spec): self {
            if ($spec instanceof Specialty) {
                DB::table('specialty_user')->insert([
                    'specialty_id' => $spec->id,
                    'user_id'      => $user->id,
                    'created_at'   => now(),
                    'updated_at'   => now(),
                ]);
            }

            return $this;
        });
    }
}
