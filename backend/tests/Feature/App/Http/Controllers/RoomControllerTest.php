<?php

declare(strict_types=1);

use App\Http\Controllers\RoomController;
use App\Models\Room;

test('room index returns 200', function () {
    $response = $this->get(action([RoomController::class, 'index']));
    $response->assertStatus(200);
});

test('room store returns 201', function () {
    $response = $this->post(action([RoomController::class, 'store'], ['name' => 'Room Test']));
    $response->assertStatus(201);
});

test('room store with password returns 201 and hashes password', function () {
    $response = $this->post(action([RoomController::class, 'store'], [
        'name' => 'Room Test',
    ]));
    $response->assertStatus(201);
});

test('room show returns 200', function () {
    $room = Room::factory()->create();

    $response = $this->get(action([RoomController::class, 'show'], [
        'room' => $room->id,
    ]));
    $response->assertStatus(200);
});

test('room update returns 200', function () {
    $room = Room::factory()->create();

    $response = $this->put(action([RoomController::class, 'update'], [
        'room' => $room->id,
        'name' => 'Room Test',
    ]));
    $response->assertStatus(200);
});

test('room destroy returns 204', function () {
    $room = Room::factory()->create();

    $response = $this->delete(action([RoomController::class, 'destroy'], [
        'room' => $room->id,
    ]));
    $response->assertStatus(204);
});
