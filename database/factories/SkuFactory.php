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
            'sku_code'          => $this->faker->word(),
            'barcode'           => $this->faker->word(),
            'description'       => $this->faker->text(),
            'unit_of_measure'   => $this->faker->randomNumber(),
            'conversion_factor' => $this->faker->randomFloat(),
            'weight'            => $this->faker->randomFloat(),
            'volume'            => $this->faker->randomFloat(),
            'created_at'        => Carbon::now(),
            'updated_at'        => Carbon::now(),

            'product_id' => Catalog::factory(),
        ];
    }
}
