<?php

declare(strict_types = 1);

namespace Database\Seeders;

use App\Enums\Models\Permission\Can;
use App\Models\Permission;
use Illuminate\Database\Seeder;

final class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permission = array_map(fn ($p): array => ['slug' => $p], Can::cases());
        Permission::upsert($permission, ['slug']);
    }
}
