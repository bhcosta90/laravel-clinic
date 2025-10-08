<?php

declare(strict_types=1);

namespace App\Actions\Room\TimeOff;

use App\Models\Room;
use App\Models\RoomTimeOff;
use App\Query\Shared\TimeOffVerify;
use DateTimeInterface;
use Illuminate\Validation\ValidationException;

final readonly class RoomTimeOffCreateAction
{
    public function __construct(private TimeOffVerify $verifyTimeOff) {}

    public function execute(
        Room $room,
        DateTimeInterface $startAt,
        DateTimeInterface $endAt,
        ?string $reason = null,
    ): RoomTimeOff {

        throw_if($this->verifyTimeOff->execute($room, $startAt, $endAt), ValidationException::withMessages([
            'time_off' => ['The doctor already has a time off during this period.'],
        ]));

        /** @var RoomTimeOff */
        return $room->timeOff()->create([
            'start_at' => $startAt,
            'end_at' => $endAt,
            'reason' => $reason,
        ]);
    }
}
