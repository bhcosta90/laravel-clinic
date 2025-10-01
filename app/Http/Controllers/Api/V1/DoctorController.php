<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\V1\Traits\ReadTrait;
use App\Http\Requests\DoctorRequest;
use App\Models\User;
use Core\Application\Builder\GraphBuilder;
use Core\Application\Builder\QueryBuilder;
use Core\Application\Handler\Doctor as Handler;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;

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

    private function baseQuery(QueryBuilder $queryBuilder): Builder
    {
        return $queryBuilder->execute(new User())
            ->where('is_doctor', true);
    }

    private function getCollection(GraphBuilder $graphBuilder, $queryBuilderResponse): Collection
    {
        return $graphBuilder->execute(
            $queryBuilderResponse,
            fields: request()->get('fields', ['id']),
            onlyFields: $this->allowedIncludes,
        );
    }
}
