<?php

declare(strict_types = 1);

namespace Database\Factories;

use App\Models\Catalog;
use App\Models\Sku;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

final class SkuFactory extends Factory
{
    protected $model = Sku::class;

    public function definition(): array
    {
        return [
            'sku_code'   => $this->faker->ean8(),
            'barcode'    => $this->faker->ean13(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'product_id' => Catalog::factory(),
        ];
    }
}
