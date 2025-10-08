<?php

declare(strict_types=1);

namespace App\Actions\Room;

use App\Models\Room;

final readonly class RoomCreateAction
{
    public function execute(string $name): Room
    {
        return Room::query()->create(['name' => $name]);
    }
}
