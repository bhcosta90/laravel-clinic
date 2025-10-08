<?php

declare(strict_types=1);

namespace App\Http\Controllers\Doctor;

use App\Actions\Doctor\TimeOff\DoctorTimeOffCreateAction;
use App\Actions\Doctor\TimeOff\DoctorTimeOffDeleteAction;
use App\Http\Requests\DoctorTimeOffRequest;
use App\Http\Resources\DoctorResource;
use App\Http\Resources\DoctorTimeOffResource;
use App\Models\Doctor;
use App\Models\DoctorTimeOff;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

final class TimeOffController
{
    public function index(Doctor $doctor): AnonymousResourceCollection
    {
        return DoctorTimeOffResource::collection($doctor->timeOff()->simplePaginate());
    }

    public function store(Doctor $doctor, DoctorTimeOffRequest $request, DoctorTimeOffCreateAction $action): DoctorResource
    {
        $response = $action->execute(
            $doctor,
            now()->parse($request->get('start_at')),
            now()->parse($request->get('start_at')),
            $request->get('reason')
        );

        return new DoctorResource($response);
    }

    public function destroy(Doctor $doctor, DoctorTimeOff $timeOff, DoctorTimeOffDeleteAction $action): JsonResponse
    {
        $action->execute(
            $doctor->id,
            $timeOff->id,
        );

        return response()->json(status: 204);
    }
}
