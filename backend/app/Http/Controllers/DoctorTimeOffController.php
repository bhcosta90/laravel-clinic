<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\DoctorTimeOffRequest;
use App\Http\Resources\DoctorTimeOffResource;
use App\Models\DoctorTimeOff;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

final class DoctorTimeOffController
{
    use AuthorizesRequests;

    public function index()
    {
        $this->authorize('viewAny', DoctorTimeOff::class);

        return DoctorTimeOffResource::collection(DoctorTimeOff::all());
    }

    public function store(DoctorTimeOffRequest $request)
    {
        $this->authorize('create', DoctorTimeOff::class);

        return new DoctorTimeOffResource(DoctorTimeOff::create($request->validated()));
    }

    public function show(DoctorTimeOff $doctorTimeOff)
    {
        $this->authorize('view', $doctorTimeOff);

        return new DoctorTimeOffResource($doctorTimeOff);
    }

    public function update(DoctorTimeOffRequest $request, DoctorTimeOff $doctorTimeOff)
    {
        $this->authorize('update', $doctorTimeOff);

        $doctorTimeOff->update($request->validated());

        return new DoctorTimeOffResource($doctorTimeOff);
    }

    public function destroy(DoctorTimeOff $doctorTimeOff)
    {
        $this->authorize('delete', $doctorTimeOff);

        $doctorTimeOff->delete();

        return response()->json();
    }
}
