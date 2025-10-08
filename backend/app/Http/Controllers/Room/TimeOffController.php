<?php

declare(strict_types=1);

namespace App\Http\Controllers\Room;

use App\Actions\Room\TimeOff\RoomTimeOffCreateAction;
use App\Actions\Room\TimeOff\RoomTimeOffDeleteAction;
use App\Http\Requests\RoomTimeOffRequest;
use App\Http\Resources\RoomResource;
use App\Http\Resources\RoomTimeOffResource;
use App\Models\Room;
use App\Models\RoomTimeOff;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

final class TimeOffController
{
    public function index(Room $room): AnonymousResourceCollection
    {
        return RoomTimeOffResource::collection($room->timeOff()->simplePaginate());
    }

    public function store(Room $room, RoomTimeOffRequest $request, RoomTimeOffCreateAction $action): RoomResource
    {
        $response = $action->execute(
            $room,
            now()->parse($request->get('start_at')),
            now()->parse($request->get('start_at')),
            $request->get('reason')
        );

        return new RoomResource($response);
    }

    public function destroy(Room $room, RoomTimeOff $timeOff, RoomTimeOffDeleteAction $action): JsonResponse
    {
        $action->execute(
            $room->id,
            $timeOff->id,
        );

        return response()->json(status: 204);
    }
}
