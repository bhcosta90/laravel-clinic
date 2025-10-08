<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\Procedure\ProcedureCreateAction;
use App\Actions\Procedure\ProcedureDeleteAction;
use App\Actions\Procedure\ProcedureUpdateAction;
use App\Http\Requests\ProcedureRequest;
use App\Http\Resources\ProcedureResource;
use App\Models\Procedure;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

final readonly class ProcedureController
{
    use AuthorizesRequests;

    public function index(): AnonymousResourceCollection
    {
        $this->authorize('viewAny', Procedure::class);

        return ProcedureResource::collection(Procedure::all());
    }

    public function store(ProcedureRequest $request, ProcedureCreateAction $action): ProcedureResource
    {
        $this->authorize('create', Procedure::class);

        return new ProcedureResource($action->execute($request->validated()['name']));
    }

    public function show(Procedure $procedure): ProcedureResource
    {
        $this->authorize('view', $procedure);

        return new ProcedureResource($procedure);
    }

    public function update(ProcedureRequest $request, Procedure $procedure, ProcedureUpdateAction $action): ProcedureResource
    {
        $this->authorize('update', $procedure);

        return new ProcedureResource($action->execute($procedure, $request->validated()['name']));
    }

    public function destroy(Procedure $procedure, ProcedureDeleteAction $action): JsonResponse
    {
        $this->authorize('delete', $procedure);

        $action->execute($procedure);

        return response()->json(status: 204);
    }
}
