<?php

declare(strict_types = 1);

use App\Services\Domain\SchedulingService;

it('returns empty collection when required builder state is missing', function (): void {
    $s      = new SchedulingService();
    $result = $s->find();
    expect($result->count())->toBe(0);
});
