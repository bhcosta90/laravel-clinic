<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\Specialty\SpecialtyCreateAction;
use App\Actions\Specialty\SpecialtyDeleteAction;
use App\Actions\Specialty\SpecialtyUpdateAction;
use App\Http\Requests\SpecialtyRequest;
use App\Http\Resources\SpecialtyResource;
use App\Models\Specialty;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

final class SpecialtyController
{
    use AuthorizesRequests;

    public function index(): AnonymousResourceCollection
    {
        $this->authorize('viewAny', Specialty::class);

        return SpecialtyResource::collection(Specialty::all());
    }

    public function store(SpecialtyRequest $request, SpecialtyCreateAction $action): SpecialtyResource
    {
        $this->authorize('create', Specialty::class);

        return new SpecialtyResource($action->execute($request->validated()['name']));
    }

    public function show(Specialty $specialty): SpecialtyResource
    {
        $this->authorize('view', $specialty);

        return new SpecialtyResource($specialty);
    }

    public function update(SpecialtyRequest $request, Specialty $specialty, SpecialtyUpdateAction $action): SpecialtyResource
    {
        $this->authorize('update', $specialty);

        $specialty->update($request->validated());

        return new SpecialtyResource($action->execute($specialty, $request->validated()['name']));
    }

    public function destroy(Specialty $specialty, SpecialtyDeleteAction $action): JsonResponse
    {
        $this->authorize('delete', $specialty);

        $action->execute($specialty);

        return response()->json(status: 204);
    }
}
