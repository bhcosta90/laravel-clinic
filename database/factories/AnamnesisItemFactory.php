<?php

declare(strict_types = 1);

namespace Database\Factories;

use App\Models\AnamnesisItem;
use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

final class AnamnesisItemFactory extends Factory
{
    protected $model = AnamnesisItem::class;

    public function definition(): array
    {
        return [
            'tenant_id'   => tenant()?->id ?: Tenant::factory(),
            'name'        => $this->faker->sentence(3),
            'description' => $this->faker->text(),
            'created_at'  => Carbon::now(),
            'updated_at'  => Carbon::now(),
        ];
    }
}
