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

final class DoctorController
{
    use AuthorizesRequests;

    public function index()
    {
        $this->authorize('viewAny', Doctor::class);

        return DoctorResource::collection(Doctor::all());
    }

    public function store(DoctorRequest $request, DoctorCreateAction $action)
    {
        $this->authorize('create', Doctor::class);
        $data = $request->validated();

        return new DoctorResource($action->execute(
            $data['name'],
            $data['crm'],
            $password = ($data['password'] ?: str()->random(8)),
        ))->additional([
            'password' => $password,
        ]);
    }

    public function show(Doctor $doctor)
    {
        $this->authorize('view', $doctor);

        return new DoctorResource($doctor);
    }

    public function update(DoctorRequest $request, Doctor $doctor, DoctorUpdateAction $action)
    {
        $this->authorize('update', $doctor);
        $data = $request->validated();

        $action->execute($doctor, $data['name'], $data['crm']);

        return new DoctorResource($doctor);
    }

    public function destroy(Doctor $doctor, DoctorDeleteAction $action)
    {
        $this->authorize('delete', $doctor);

        $action->execute($doctor);

        return response()->json();
    }
}
