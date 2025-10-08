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

final class RoomController
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

    public function show(Room $procedure): RoomResource
    {
        $this->authorize('view', $procedure);

        return new RoomResource($procedure);
    }

    public function update(RoomRequest $request, Room $procedure, RoomUpdateAction $action): RoomResource
    {
        $this->authorize('update', $procedure);

        return new RoomResource($action->execute($procedure, $request->validated()['name']));
    }

    public function destroy(Room $procedure, RoomDeleteAction $action): JsonResponse
    {
        $this->authorize('delete', $procedure);

        $action->execute($procedure);

        return response()->json(status: 204);
    }
}
