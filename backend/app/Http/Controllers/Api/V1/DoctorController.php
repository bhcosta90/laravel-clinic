<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\V1\Traits\ReadTrait;
use App\Http\Requests\DoctorRequest;
use App\Models\User;
use Core\Application\Handler\Doctor as Handler;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Response;

final class DoctorController
{
    use ReadTrait;

    private array $allowedIncludes = [
        'id',
        'name',
    ];

    public function store(DoctorRequest $procedureRequest, Handler\DoctorCreateHandler $handler)
    {
        return response()->json([
            'data' => $handler->execute($procedureRequest->name),
        ], Response::HTTP_CREATED);
    }

    public function update(DoctorRequest $procedureRequest, Handler\DoctorUpdateHandler $handler, string $id)
    {
        return response()->json([
            'data' => $handler->execute($id, $procedureRequest->validated()),
        ]);
    }

    public function destroy(Handler\DoctorDeleteHandler $handler, string $id)
    {
        return response()->json([
            'data' => $handler->execute($id),
        ]);
    }

    protected function model(): Model
    {
        return new User();
    }

    protected function defaultQuery(Builder $queryBuilder)
    {
        return $queryBuilder->where('is_doctor', true);
    }
}
