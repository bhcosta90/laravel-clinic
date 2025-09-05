<?php

declare(strict_types = 1);

namespace Database\Factories;

use App\Models\Ean;
use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

final class EanFactory extends Factory
{
    protected $model = Ean::class;

    public function definition(): array
    {
        return [
            'tenant_id'  => tenant()?->id ?: Tenant::factory(),
            'sku_code'   => $this->faker->unique()->ean8(),
            'barcode'    => $this->faker->unique()->ean13(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
