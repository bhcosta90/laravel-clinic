<?php

declare(strict_types=1);

use App\Models\User;

test('to array', function () {
    $user = User::factory()->create()->refresh();

    expect(array_keys($user->toArray()))
        ->toBe([
            'id',
            'username',
            'email',
            'email_verified_at',
            'created_at',
            'updated_at',
            'deleted_at',
        ]);
});
