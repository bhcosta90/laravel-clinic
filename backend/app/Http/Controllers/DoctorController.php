<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\Doctor\DoctorCreateAction;
use App\Actions\Doctor\DoctorDeleteAction;
use App\Actions\Doctor\DoctorUpdateAction;
use App\Http\Requests\DoctorRequest;
use App\Http\Resources\DoctorResource;
use App\Models\Doctor;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

final class DoctorController
{
    use AuthorizesRequests;

    public function index(): AnonymousResourceCollection
    {
        $this->authorize('viewAny', Doctor::class);

        return DoctorResource::collection(Doctor::all());
    }

    public function store(DoctorRequest $request, DoctorCreateAction $action): JsonResponse
    {
        $this->authorize('create', Doctor::class);
        $data = $request->validated();
        $password = $data['password'] ?? str()->random(8);

        return (new DoctorResource($action->execute(
            $data['name'],
            $data['crm'],
            $password,
        ))->additional([
            'password' => $password,
        ]))->response()->setStatusCode(201);
    }

    public function show(Doctor $doctor): DoctorResource
    {
        $this->authorize('view', $doctor);

        return new DoctorResource($doctor);
    }

    public function update(DoctorRequest $request, Doctor $doctor, DoctorUpdateAction $action): DoctorResource
    {
        $this->authorize('update', $doctor);
        $data = $request->validated();

        $action->execute($doctor, $data['name'], $data['crm']);

        return new DoctorResource($doctor);
    }

    public function destroy(Doctor $doctor, DoctorDeleteAction $action): JsonResponse
    {
        $this->authorize('delete', $doctor);

        $action->execute($doctor);

        return response()->json(status: 204);
    }
}
