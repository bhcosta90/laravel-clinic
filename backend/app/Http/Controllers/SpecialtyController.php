<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\SpecialtyRequest;
use App\Http\Resources\SpecialtyResource;
use App\Models\Specialty;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

final class SpecialtyController
{
    use AuthorizesRequests;

    public function index()
    {
        $this->authorize('viewAny', Specialty::class);

        return SpecialtyResource::collection(Specialty::all());
    }

    public function store(SpecialtyRequest $request)
    {
        $this->authorize('create', Specialty::class);

        return new SpecialtyResource(Specialty::create($request->validated()));
    }

    public function show(Specialty $specialty)
    {
        $this->authorize('view', $specialty);

        return new SpecialtyResource($specialty);
    }

    public function update(SpecialtyRequest $request, Specialty $specialty)
    {
        $this->authorize('update', $specialty);

        $specialty->update($request->validated());

        return new SpecialtyResource($specialty);
    }

    public function destroy(Specialty $specialty)
    {
        $this->authorize('delete', $specialty);

        $specialty->delete();

        return response()->json();
    }
}
