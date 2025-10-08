<?php

declare(strict_types=1);

use App\Actions\Room\TimeOff\RoomTimeOffDeleteAction;
use App\Models\Room;
use App\Models\RoomTimeOff;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertSoftDeleted;

test('delete time off action', function () {
    $room = Room::factory()->create();
    $time = RoomTimeOff::factory()->for($room)->create();

    $response = app(RoomTimeOffDeleteAction::class)->execute($room->id, $time->id);

    expect($response)->toBeTrue();

    assertSoftDeleted(RoomTimeOff::class, ['id' => $time->id]);
});

test('delete time off action with mismatched room', function () {
    $room = Room::factory()->create();
    $time = RoomTimeOff::factory()->create();

    $response = app(RoomTimeOffDeleteAction::class)->execute($room->id, $time->id);

    expect($response)->toBeFalse();

    assertDatabaseHas(RoomTimeOff::class, ['id' => $time->id, 'deleted_at' => null]);
});
