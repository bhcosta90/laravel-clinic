<?php

declare(strict_types=1);

use App\Actions\Room\RoomCreateAction;
use App\Models\Room;

use function Pest\Laravel\assertDatabaseHas;

test('create room action', function () {
    $name = 'Test Room';

    $room = app(RoomCreateAction::class)->execute($name);

    expect($room)->toBeInstanceOf(Room::class)
        ->and($room->name)->toBe($name);

    assertDatabaseHas(Room::class, compact('name'));
});
