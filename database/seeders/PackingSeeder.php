<?php

declare(strict_types = 1);

namespace Database\Seeders;

use App\Models\Ean;
use App\Models\Packing;
use Illuminate\Database\Seeder;

final class PackingSeeder extends Seeder
{
    public function run(): void
    {
        Ean::query()->each(function (Ean $item): void {
            $packing = Packing::factory()->make();
            $item->packings()->create($packing->toArray());
        });
    }
}
