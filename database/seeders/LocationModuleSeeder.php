<?php

declare(strict_types = 1);

namespace Database\Seeders;

use App\Models\LocationModule;
use Illuminate\Database\Seeder;

final class LocationModuleSeeder extends Seeder
{
    public function run(): void
    {
        LocationModule::factory()->create();
    }
}
