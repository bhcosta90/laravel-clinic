<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\PatientRequest;
use Core\Application\Handler\Patient as Handler;

final class PatientController
{
    public function show(Handler\PatientShowHandler $handler, string $id)
    {
        return response()->json([
            'data' => $handler->execute($id),
        ]);
    }

    public function store(PatientRequest $procedureRequest, Handler\PatientCreateHandler $handler)
    {
        return response()->json([
            'data' => $handler->execute(
                $procedureRequest->code,
                $procedureRequest->name,
            ),
        ]);
    }

    public function update(PatientRequest $procedureRequest, Handler\PatientUpdateHandler $handler, string $id)
    {
        return response()->json([
            'data' => $handler->execute(
                $id,
                $procedureRequest->validated(),
            ),
        ]);
    }

    public function destroy(Handler\PatientDeleteHandler $handler, string $id)
    {
        return response()->json([
            'data' => $handler->execute($id),
        ]);
    }
}
