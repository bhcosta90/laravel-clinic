<?php

declare(strict_types = 1);

namespace App\Services;

use App\Models\Room;
use Costa\Service\Service;

final class RoomService extends Service
{
    protected function model(): Room
    {
        return new Room();
    }

    protected function search(): array
    {
        return ['code', 'name'];
    }
}
