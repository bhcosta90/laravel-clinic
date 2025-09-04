<?php

declare(strict_types = 1);

namespace Database\Seeders;

use App\Models\Sector;
use Illuminate\Database\Seeder;

final class SectorSeeder extends Seeder
{
    public function run(): void
    {
        Sector::factory(25)->create(['tenant_id' => DatabaseSeeder::TenantId]);
    }
}
