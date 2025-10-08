<?php

declare(strict_types=1);

namespace App\Actions\Room;

use App\Models\Room;

final class RoomUpdateAction
{
    public function execute(Room $model, string $name): Room
    {
        return tap($model)->update(['name' => $name]);
    }
}
