<?php

declare(strict_types = 1);

namespace Database\Seeders;

use App\Models\Frequency;
use Illuminate\Database\Seeder;

final class FrequencySeeder extends Seeder
{
    public function run(): void
    {
        Frequency::factory(25)->create(['tenant_id' => DatabaseSeeder::TenantId]);
    }
}
