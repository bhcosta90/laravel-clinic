<?php

declare(strict_types = 1);

namespace App\Services;

use App\Abstracts\Service;
use App\Models\Room;

final class RoomService extends Service
{
    protected function model(): Room
    {
        return new Room();
    }

    protected function search(): array
    {
        return ['name'];
    }
}
