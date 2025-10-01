<?php

use App\Models\User;
use Core\Domain\Entities\DoctorEntity;
use Core\Domain\Repository\DoctorRepositoryInterface;

beforeEach(function () {
    $this->doctor = User::factory()->create();
    $this->handler = app(DoctorRepositoryInterface::class);
});

test('100', function () {
    $response = $this->handler->find($this->doctor->id);

    expect($response)->toBeInstanceOf(DoctorEntity::class);
});
