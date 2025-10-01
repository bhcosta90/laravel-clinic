<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Doctor\DoctorIndexRequest;
use App\Http\Requests\DoctorRequest;
use App\Models\User;
use Core\Application\Builder\GraphBuilder;
use Core\Application\Builder\QueryBuilder;
use Core\Application\Handler\Doctor as Handler;
use Illuminate\Http\Request;

final class DoctorController
{
    public function index(QueryBuilder $queryBuilder, GraphBuilder $graphBuilder, DoctorIndexRequest $request)
    {
        $queryBuilderResponse = $queryBuilder->execute(new User())
            ->where('is_doctor', true)
            ->orderBy($request->get('order_column', 'id'), $request->get('order_direction'))
            ->simplePaginate();

        $graphBuilderResponse = $graphBuilder->execute($queryBuilderResponse, fields: $request->get('fields', ['id']));

        return response()->json([
            'doctors' => $graphBuilderResponse,
        ]);
    }

    public function show(QueryBuilder $queryBuilder, GraphBuilder $graphBuilder, Request $request, int $doctorId)
    {
        $queryBuilderResponse = $queryBuilder->execute(new User())
            ->where('is_doctor', true)
            ->where('id', $doctorId)
            ->sole();

        $graphBuilderResponse = $graphBuilder->execute($queryBuilderResponse, fields: $request->get('fields', ['id']));

        return response()->json([
            'doctor' => $graphBuilderResponse,
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
