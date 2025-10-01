<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\DoctorRequest;
use Core\Application\Handler\Doctor as Handler;

final class DoctorController
{
    public function show(Handler\DoctorShowHandler $handler, string $id)
    {
        return response()->json([
            'data' => $handler->execute($id),
        ]);
    }

    public function store(DoctorRequest $procedureRequest, Handler\DoctorCreateHandler $handler)
    {
        return response()->json([
            'data' => $handler->execute(
                $procedureRequest->name,
            ),
        ]);
    }

    public function update(DoctorRequest $procedureRequest, Handler\DoctorUpdateHandler $handler, string $id)
    {
        return response()->json([
            'data' => $handler->execute(
                $id,
                $procedureRequest->validated(),
            ),
        ]);
    }

    public function destroy(Handler\DoctorDeleteHandler $handler, string $id)
    {
        return response()->json([
            'data' => $handler->execute($id),
        ]);
    }
}
