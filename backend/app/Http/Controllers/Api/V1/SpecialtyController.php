<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\V1\Traits\ReadTrait;
use App\Http\Requests\SpecialtyRequest;
use App\Models\Specialty;
use Core\Application\Handler\Specialty as Handler;
use Illuminate\Database\Eloquent\Model;

final class SpecialtyController
{
    use ReadTrait;

    private array $allowedIncludes = [
        'uuid',
        'name',
        'code',
    ];

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

    protected function model(): Model
    {
        return new Specialty();
    }
}
