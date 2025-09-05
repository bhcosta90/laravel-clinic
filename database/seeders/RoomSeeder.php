<?php

declare(strict_types = 1);

namespace Database\Seeders;

use App\Models\Room;
use Illuminate\Database\Seeder;

final class RoomSeeder extends Seeder
{
    public function run(): void
    {
        Room::factory(25)->create();
    }
}
