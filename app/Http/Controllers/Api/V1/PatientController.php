<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\V1\Traits\ReadTrait;
use App\Http\Requests\PatientRequest;
use App\Models\Patient;
use Core\Application\Handler\Patient as Handler;
use Illuminate\Database\Eloquent\Model;

final class PatientController
{
    use ReadTrait;

    private array $allowedIncludes = [
        'uuid',
        'name',
        'code',
    ];

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

    protected function model(): Model
    {
        return new Patient();
    }
}
