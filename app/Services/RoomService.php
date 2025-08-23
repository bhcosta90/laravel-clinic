<?php

declare(strict_types = 1);

namespace App\Services;

use App\Abstracts\Service;
use App\Models\Room;
use Illuminate\Container\Attributes\CurrentUser;
use QuantumTecnology\ControllerBasicsExtension\Builder\BuilderQuery;

final class RoomService extends Service
{
    protected function model(): Room
    {
        return new Room();
    }

    protected function index(string $search, ?array $filters = [])
    {
        return app(BuilderQuery::class)->execute(new Room(), [], [
            '(byFilter,name)' => $search,
        ] + ($filters ?: []));
    }
}
