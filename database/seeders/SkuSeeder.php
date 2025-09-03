<?php

declare(strict_types = 1);

namespace Database\Seeders;

use App\Models\Catalog;
use App\Models\Sku;
use Illuminate\Database\Seeder;

final class SkuSeeder extends Seeder
{
    public function run(): void
    {
        Catalog::query()->each(function ($item): void {
            $sku = Sku::factory()->make();
            $item->skus()->create($sku->toArray());
        });
    }
}
