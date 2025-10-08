<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\InsuranceRequest;
use App\Http\Resources\InsuranceResource;
use App\Models\Insurance;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

final class InsuranceController
{
    use AuthorizesRequests;

    public function index(): AnonymousResourceCollection
    {
        $this->authorize('viewAny', Insurance::class);

        return InsuranceResource::collection(Insurance::all());
    }

    public function store(InsuranceRequest $request): InsuranceResource
    {
        $this->authorize('create', Insurance::class);

        return new InsuranceResource(Insurance::query()->create($request->validated()));
    }

    public function show(Insurance $insurance): InsuranceResource
    {
        $this->authorize('view', $insurance);

        return new InsuranceResource($insurance);
    }

    public function update(InsuranceRequest $request, Insurance $insurance): InsuranceResource
    {
        $this->authorize('update', $insurance);

        $insurance->update($request->validated());

        return new InsuranceResource($insurance);
    }

    public function destroy(Insurance $insurance): JsonResponse
    {
        $this->authorize('delete', $insurance);

        $insurance->delete();

        return response()->json();
    }
}
