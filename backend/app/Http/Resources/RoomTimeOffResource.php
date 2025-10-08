<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\RoomTimeOff;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin RoomTimeOff */
final class RoomTimeOffResource extends JsonResource
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

            'room_id' => $this->room_id,

            'room' => new RoomResource($this->whenLoaded('room')),
        ];
    }
}
