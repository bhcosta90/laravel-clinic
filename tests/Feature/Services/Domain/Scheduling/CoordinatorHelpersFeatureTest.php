<?php

declare(strict_types = 1);

use App\Services\Domain\Scheduling\CoordinatorHelpers;

beforeEach(function (): void {  });

afterEach(function (): void { /* nothing */ });

it('detects cap reached when insurer has zero max_total_appointments', function (): void {
    $insurer                         = new stdClass();
    $insurer->max_total_appointments = 0;

    // No appointments yet, so count() >= 0 is true -> cap reached
    $helpers = new CoordinatorHelpers();
    expect($helpers->isCapReached($insurer))->toBeTrue();
});

it('buildRoomIds returns empty when not required and no roomCode', function (): void {
    $helpers = new CoordinatorHelpers();
    expect($helpers->buildRoomIds(false, null))->toBeArray()->toBe([]);
});
