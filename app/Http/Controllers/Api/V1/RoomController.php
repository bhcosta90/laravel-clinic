<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\RoomRequest;
use Core\Application\Handler\Room as Handler;

final class RoomController
{
    public function show(Handler\RoomShowHandler $handler, string $id)
    {
        return response()->json([
            'data' => $handler->execute($id),
        ]);
    }

    public function store(RoomRequest $procedureRequest, Handler\RoomCreateHandler $handler)
    {
        return response()->json([
            'data' => $handler->execute(
                $procedureRequest->code,
                $procedureRequest->name,
                $procedureRequest->is_active,
            ),
        ]);
    }

    public function update(RoomRequest $procedureRequest, Handler\RoomUpdateHandler $handler, string $id)
    {
        return response()->json([
            'data' => $handler->execute(
                $id,
                $procedureRequest->validated(),
            ),
        ]);
    }

    public function destroy(Handler\RoomDeleteHandler $handler, string $id)
    {
        return response()->json([
            'data' => $handler->execute($id),
        ]);
    }
}
