<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\Patient\PatientCreateAction;
use App\Actions\Patient\PatientDeleteAction;
use App\Actions\Patient\PatientUpdateAction;
use App\Http\Requests\PatientRequest;
use App\Http\Resources\PatientResource;
use App\Models\Patient;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

final class PatientController
{
    use AuthorizesRequests;

    public function index(): AnonymousResourceCollection
    {
        $this->authorize('viewAny', Patient::class);

        return PatientResource::collection(Patient::all());
    }

    public function store(PatientRequest $request, PatientCreateAction $action): PatientResource
    {
        $this->authorize('create', Patient::class);

        return new PatientResource($action->execute($request->validated()['name']));
    }

    public function show(Patient $patient): PatientResource
    {
        $this->authorize('view', $patient);

        return new PatientResource($patient);
    }

    public function update(PatientRequest $request, Patient $patient, PatientUpdateAction $action): PatientResource
    {
        $this->authorize('update', $patient);

        return new PatientResource($action->execute($patient, $request->validated()['name']));
    }

    public function destroy(Patient $patient, PatientDeleteAction $action): JsonResponse
    {
        $this->authorize('delete', $patient);

        $action->execute($patient);

        return response()->json(status: 204);
    }
}
