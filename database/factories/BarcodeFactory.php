<?php

declare(strict_types = 1);

namespace Database\Factories;

use App\Models\Barcode;
use App\Models\Packing;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

final class BarcodeFactory extends Factory
{
    protected $model = Barcode::class;

    public function definition(): array
    {
        return [
            'ean'        => $this->faker->word(),
            'type'       => $this->faker->randomNumber(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'packing_id' => Packing::factory(),
        ];
    }
}
