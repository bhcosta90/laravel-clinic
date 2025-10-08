<?php

declare(strict_types=1);

use App\Actions\Room\RoomUpdateAction;
use App\Models\Room;

use function Pest\Laravel\assertDatabaseHas;

test('update room action', function () {
    $room = Room::factory()->create();

    $newName = 'Updated Room';

    $response = app(RoomUpdateAction::class)->execute($room, $newName);

    expect($response)->toBeInstanceOf(Room::class)
        ->and($room->name)->toBe($newName);

    assertDatabaseHas(Room::class, ['name' => $newName]);
});
