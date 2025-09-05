<?php

declare(strict_types = 1);

namespace Database\Seeders;

use App\Models\Catalog;
use Illuminate\Database\Seeder;

final class CatalogSeeder extends Seeder
{
    public function run(): void
    {
        Catalog::factory(25)->create();
    }
}
