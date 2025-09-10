<?php

declare(strict_types = 1);

use App\Models\User;
use App\Models\UserSchedule;
use App\Services\Domain\NextAvailableSlotService;
use Carbon\Carbon;

it('honors provided from date and skips past-end intervals', function (): void {

    $user = User::factory()->create();

    // Single short window today 09:00-09:30, then another tomorrow 10:00-10:30
    UserSchedule::create(['user_id' => $user->id, 'day_of_week' => 1, 'start_time' => '09:00:00', 'end_time' => '09:30:00', 'slot_minutes' => 30]);
    UserSchedule::create(['user_id' => $user->id, 'day_of_week' => 2, 'start_time' => '10:00:00', 'end_time' => '10:30:00', 'slot_minutes' => 30]);

    // Set base date to Monday 12:00 so that Monday window is already past.
    $mondayNoon = Carbon::parse('2025-09-01 12:00:00'); // Monday
    Carbon::setTestNow($mondayNoon);

    $service = new NextAvailableSlotService();

    // Passing explicit from date should be used instead of now()
    $next = $service->getNextAvailable($user->id, $mondayNoon);

    // Should skip Monday (past) and return Tuesday 10:00
    expect($next?->toDateTimeString())->toBe('2025-09-02 10:00:00');

    Carbon::setTestNow();
});
