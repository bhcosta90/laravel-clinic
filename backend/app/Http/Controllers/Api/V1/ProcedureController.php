<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\V1\Traits\ReadTrait;
use App\Http\Requests\ProcedureRequest;
use App\Models\Procedure;
use Core\Application\Handler\Procedure as Handler;
use Illuminate\Database\Eloquent\Model;

final class ProcedureController
{
    use ReadTrait;

    private array $allowedIncludes = [
        'uuid',
        'name',
        'code',
    ];

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

    protected function model(): Model
    {
        return new Procedure();
    }
}
