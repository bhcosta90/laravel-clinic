<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\ProcedureRequest;
use Core\Application\Handler\Procedure as Handler;

class ProcedureController
{
    public function show(Handler\ProcedureShowHandler $handler, string $id)
    {
        return response()->json([
            'data' => $handler->execute($id),
        ]);
    }

    public function store(ProcedureRequest $procedureRequest, Handler\ProcedureCreateHandler $handler)
    {
        return response()->json([
            'data' => $handler->execute(
                $procedureRequest->code,
                $procedureRequest->name,
                $procedureRequest->min_duration_minutes,
                $procedureRequest->max_duration_minutes
            ),
        ]);
    }

    public function update(ProcedureRequest $procedureRequest, Handler\ProcedureUpdateHandler $handler, string $id)
    {
        return response()->json([
            'data' => $handler->execute(
                $id,
                $procedureRequest->validated(),
            ),
        ]);
    }

    public function destroy(Handler\ProcedureDeleteHandler $handler, string $id)
    {
        return response()->json([
            'data' => $handler->execute($id),
        ]);
    }
}
