<?php

declare(strict_types=1);

namespace App\Actions\Room\TimeOff;

use App\Models\RoomTimeOff;

final readonly class RoomTimeOffDeleteAction
{
    public function execute(
        int $idRoom,
        int $idTimeOff,
    ): bool {
        return (bool) RoomTimeOff::query()
            ->where('room_id', $idRoom)
            ->where('id', $idTimeOff)
            ->delete();
    }
}
