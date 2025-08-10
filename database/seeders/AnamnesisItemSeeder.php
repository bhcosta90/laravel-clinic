<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\AnamnesisGroup;
use App\Models\AnamnesisItem;
use Illuminate\Database\Seeder;

final class AnamnesisItemSeeder extends Seeder
{
    public function run(): void
    {
        $groupIds = AnamnesisGroup::pluck('id')->toArray();

        AnamnesisItem::factory(25)->make()->each(function ($item) use ($groupIds): void {
            $item->anamnesis_group_id = collect($groupIds)->random();
            $item->save();
        });
    }
}
