<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\DoctorTimeOff;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin DoctorTimeOff */
final class DoctorTimeOffResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'start_at' => $this->start_at,
            'end_at' => $this->end_at,
            'reason' => $this->reason,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

            'doctor_id' => $this->doctor_id,

            'doctor' => new DoctorResource($this->whenLoaded('doctor')),
        ];
    }
}
