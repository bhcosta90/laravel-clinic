<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\Room\RoomCreateAction;
use App\Actions\Room\RoomDeleteAction;
use App\Actions\Room\RoomUpdateAction;
use App\Http\Requests\RoomRequest;
use App\Http\Resources\RoomResource;
use App\Models\Room;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

final readonly class RoomController
{
    use AuthorizesRequests;

    public function index(): AnonymousResourceCollection
    {
        $this->authorize('viewAny', Room::class);

        return RoomResource::collection(Room::all());
    }

    public function store(RoomRequest $request, RoomCreateAction $action): RoomResource
    {
        $this->authorize('create', Room::class);

        return new RoomResource($action->execute($request->validated()['name']));
    }

    public function show(Room $room): RoomResource
    {
        $this->authorize('view', $room);

        return new RoomResource($room);
    }

    public function update(RoomRequest $request, Room $room, RoomUpdateAction $action): RoomResource
    {
        $this->authorize('update', $room);

        return new RoomResource($action->execute($room, $request->validated()['name']));
    }

    public function destroy(Room $room, RoomDeleteAction $action): JsonResponse
    {
        $this->authorize('delete', $room);

        $action->execute($room);

        return response()->json(status: 204);
    }
}
