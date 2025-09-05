<?php

declare(strict_types = 1);

namespace Database\Seeders;

use App\Models\Warehouse;
use Illuminate\Database\Seeder;

use function warehouse;

final class WarehouseSeeder extends Seeder
{
    public function run(): void
    {
        warehouse(Warehouse::factory()->create());
    }
}
