<?php

declare(strict_types = 1);

namespace Database\Seeders;

use App\Models\Catalog;
use App\Models\Ean;
use Illuminate\Database\Seeder;

final class EanSeeder extends Seeder
{
    public function run(): void
    {
        Catalog::query()->each(function (Catalog $item): void {
            $sku = Ean::factory()->make();
            $item->ean()->create($sku->toArray());
        });
    }
}
