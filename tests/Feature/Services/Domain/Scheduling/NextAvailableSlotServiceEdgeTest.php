<?php

declare(strict_types = 1);

use App\Models\User;
use App\Models\UserSchedule;
use App\Services\Domain\NextAvailableSlotService;
use Carbon\Carbon;

it('sets candidate to start when from time is before start and skips when after end', function (): void {

    $user = User::factory()->create();
    // Monday schedule 09:00-17:00
    UserSchedule::create(['user_id' => $user->id, 'day_of_week' => 1, 'start_time' => '09:00:00', 'end_time' => '17:00:00', 'slot_minutes' => 30]);

    // Case A: from at 08:10 on Monday -> candidate should be set to start 09:00
    $fromA = Carbon::parse('2025-09-01 08:10:00'); // Monday
    $svc   = new NextAvailableSlotService();
    $nextA = $svc->getNextAvailable($user->id, $fromA);
    expect($nextA?->toDateTimeString())->toBe('2025-09-01 09:00:00');

    // Case B: from late at 17:30 Monday -> skip to next Monday (no other schedules), so null within 14 days? But 14-day search: next Monday within 7 days
    $fromB = Carbon::parse('2025-09-01 17:30:00');
    $nextB = $svc->getNextAvailable($user->id, $fromB);
    expect($nextB?->toDateTimeString())->toBe('2025-09-08 09:00:00');
});
