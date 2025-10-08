<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\RoomTimeOffRequest;
use App\Http\Resources\RoomTimeOffResource;
use App\Models\RoomTimeOff;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

final class RoomTimeOffController
{
    use AuthorizesRequests;

    public function index(): AnonymousResourceCollection
    {
        $this->authorize('viewAny', RoomTimeOff::class);

        return RoomTimeOffResource::collection(RoomTimeOff::all());
    }

    public function store(RoomTimeOffRequest $request): RoomTimeOffResource
    {
        $this->authorize('create', RoomTimeOff::class);

        return new RoomTimeOffResource(RoomTimeOff::query()->create($request->validated()));
    }

    public function show(RoomTimeOff $roomTimeOff): RoomTimeOffResource
    {
        $this->authorize('view', $roomTimeOff);

        return new RoomTimeOffResource($roomTimeOff);
    }

    public function update(RoomTimeOffRequest $request, RoomTimeOff $roomTimeOff): RoomTimeOffResource
    {
        $this->authorize('update', $roomTimeOff);

        $roomTimeOff->update($request->validated());

        return new RoomTimeOffResource($roomTimeOff);
    }

    public function destroy(RoomTimeOff $roomTimeOff): JsonResponse
    {
        $this->authorize('delete', $roomTimeOff);

        $roomTimeOff->delete();

        return response()->json();
    }
}
