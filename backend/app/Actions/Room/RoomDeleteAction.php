<?php

declare(strict_types=1);

namespace App\Actions\Room;

use App\Models\Room;

final readonly class RoomDeleteAction
{
    public function execute(Room $model): bool
    {
        return $model->delete();
    }
}
