<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\SpecialtyRequest;
use Core\Application\Handler\Specialty as Handler;

final class SpecialtyController
{
    public function show(Handler\SpecialtyShowHandler $handler, string $id)
    {
        return response()->json([
            'data' => $handler->execute($id),
        ]);
    }

    public function store(SpecialtyRequest $procedureRequest, Handler\SpecialtyCreateHandler $handler)
    {
        return response()->json([
            'data' => $handler->execute(
                $procedureRequest->code,
                $procedureRequest->name,
            ),
        ]);
    }

    public function update(SpecialtyRequest $procedureRequest, Handler\SpecialtyUpdateHandler $handler, string $id)
    {
        return response()->json([
            'data' => $handler->execute(
                $id,
                $procedureRequest->validated(),
            ),
        ]);
    }

    public function destroy(Handler\SpecialtyDeleteHandler $handler, string $id)
    {
        return response()->json([
            'data' => $handler->execute($id),
        ]);
    }
}
