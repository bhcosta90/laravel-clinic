<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\AnamnesisGroup;
use Illuminate\Database\Seeder;

final class AnamnesisGroupSeeder extends Seeder
{
    public function run(): void
    {
        AnamnesisGroup::factory(25)->create();
    }
}
