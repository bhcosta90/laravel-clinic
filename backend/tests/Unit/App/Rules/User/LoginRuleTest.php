<?php

declare(strict_types=1);

use App\Models\User;
use App\Rules\User\LoginRule;

test('username validation passes for valid usernames', function (string $username) {
    $rule = new LoginRule();

    $rule->validate('username', $username, fn (string $errorMessage) => $this->fail($errorMessage));

    expect(true)->toBeTrue();
})->with([
    'valid_username',
    'user123',
    '_underscore',
]);

test('username validation fails if there is not 2 characters', function (string $username) {
    $rule = new LoginRule();

    $fail = fn (string $errorMessage) => throw new InvalidArgumentException($errorMessage);

    $rule->validate('username', $username, $fail);
})->with([
    'a',
    '1',
    '',
])->throws(InvalidArgumentException::class, 'The :attribute must contain at least 2 letters.');

test('username validation fails for invalid usernames', function (string $username) {
    $rule = new LoginRule();

    $fail = fn (string $errorMessage) => throw new InvalidArgumentException($errorMessage);

    $rule->validate('username', $username, $fail);
})->with([
    'invalid username',
    'invalid@username',
    'username!',
    '12345$',
    '-',
    '   ',
])->throws(InvalidArgumentException::class);

test('username validation fails for reserved usernames', function () {
    $user = User::factory()->create();

    $rule = new LoginRule($user);

    $reservedUsername = 'admin'; // Example of a reserved username

    $fail = fn (string $errorMessage) => throw new InvalidArgumentException($errorMessage);

    $rule->validate('username', $reservedUsername, $fail);
})->throws(InvalidArgumentException::class, 'The :attribute is reserved.');

test('username validation fails for existing usernames', function () {
    User::factory()->create(['username' => 'existing_user']);

    $rule = new LoginRule();

    $fail = fn (string $errorMessage) => throw new InvalidArgumentException($errorMessage);

    $rule->validate('username', 'existing_user', $fail);
})->throws(InvalidArgumentException::class, 'The :attribute has already been taken.');
