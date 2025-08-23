<?php

declare(strict_types = 1);

namespace Database\Seeders;

use App\Models\Tenant;
use Illuminate\Database\Seeder;

final class DatabaseSeeder extends Seeder
{
    public const TenantId = '9c97475a-6867-4f75-a1e4-3ac81eebcf2c';

    public function run(): void
    {
        Tenant::factory()->create(['id' => self::TenantId]);

        $this->call(TenantSeeder::class);
    }
}
