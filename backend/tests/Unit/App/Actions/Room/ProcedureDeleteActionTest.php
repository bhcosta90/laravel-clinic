<?php

declare(strict_types=1);

use App\Actions\Room\RoomDeleteAction;
use App\Models\Room;

use function Pest\Laravel\assertSoftDeleted;

test('delete room action', function () {
    $room = Room::factory()->create();

    $response = app(RoomDeleteAction::class)->execute($room);

    expect($response)->toBeTrue();

    assertSoftDeleted(Room::class, ['id' => $room->id]);
});
