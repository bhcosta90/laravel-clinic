<?php

declare(strict_types = 1);

namespace Database\Seeders;

use App\Models\Packing;
use App\Models\Sku;
use Illuminate\Database\Seeder;

final class PackingSeeder extends Seeder
{
    public function run(): void
    {
        Sku::query()->each(function (Sku $item): void {
            $packing = Packing::factory()->make();
            $item->packings()->create($packing->toArray());
        });
    }
}
