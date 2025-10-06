<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\ProcedureRequest;
use App\Http\Resources\ProcedureResource;
use App\Models\Procedure;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

final class ProcedureController
{
    use AuthorizesRequests;

    public function index()
    {
        $this->authorize('viewAny', Procedure::class);

        return ProcedureResource::collection(Procedure::all());
    }

    public function store(ProcedureRequest $request)
    {
        $this->authorize('create', Procedure::class);

        return new ProcedureResource(Procedure::create($request->validated()));
    }

    public function show(Procedure $procedure)
    {
        $this->authorize('view', $procedure);

        return new ProcedureResource($procedure);
    }

    public function update(ProcedureRequest $request, Procedure $procedure)
    {
        $this->authorize('update', $procedure);

        $procedure->update($request->validated());

        return new ProcedureResource($procedure);
    }

    public function destroy(Procedure $procedure)
    {
        $this->authorize('delete', $procedure);

        $procedure->delete();

        return response()->json();
    }
}
