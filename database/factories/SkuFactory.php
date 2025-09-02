<?php

declare(strict_types = 1);

namespace Database\Factories;

use App\Models\Sku;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

final class SkuFactory extends Factory
{
    protected $model = Sku::class;

    public function definition(): array
    {
        return [
            'tenant_id'  => DatabaseSeeder::TenantId,
            'sku_code'   => $this->faker->unique()->ean8(),
            'gtin'       => $this->faker->unique()->ean13(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
