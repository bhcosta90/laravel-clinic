<?php

declare(strict_types=1);

namespace App\Http\Controllers;

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

    public function store(DoctorRequest $request)
    {
        $this->authorize('create', Doctor::class);

        return new DoctorResource(Doctor::create($request->validated()));
    }

    public function show(Doctor $doctor)
    {
        $this->authorize('view', $doctor);

        return new DoctorResource($doctor);
    }

    public function update(DoctorRequest $request, Doctor $doctor)
    {
        $this->authorize('update', $doctor);

        $doctor->update($request->validated());

        return new DoctorResource($doctor);
    }

    public function destroy(Doctor $doctor)
    {
        $this->authorize('delete', $doctor);

        $doctor->delete();

        return response()->json();
    }
}
