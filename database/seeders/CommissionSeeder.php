<?php

declare(strict_types = 1);

namespace Database\Seeders;

use App\Models\Commission;
use App\Models\User;
use Illuminate\Database\Seeder;

final class CommissionSeeder extends Seeder
{
    public function run(): void
    {
        $groupIds = User::query()->whereIsEmployee(true)->pluck('id')->toArray();

        Commission::factory(25)->make()->each(function ($item) use ($groupIds): void {
            $item->tenant_id = DatabaseSeeder::TenantId;
            $item->user_id   = collect($groupIds)->random();
            $item->save();
        });
    }
}
