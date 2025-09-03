<?php

declare(strict_types = 1);

use App\Models\Appointment;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

pest()->extend(Tests\TestCase::class)
    ->use(Illuminate\Foundation\Testing\LazilyRefreshDatabase::class)
    ->in('Feature');

// expect()->extend('toBeOne', fn () => $this->toBe(1));

function makeUser(): User
{
    $user = User::factory()->createTenant()->create(['is_employee' => true]);
    Auth::login($user);

    return $user;
}

function makeAppointment(User $user, array $data = []): Appointment
{
    return Appointment::factory()->create($data + [
        'user_id'      => $user->id,
        'agreement_id' => null,
        'date'         => when($data['date'], Carbon::parse($data['date'])),
        'is_return'    => false,
        'status'       => null,
        'is_paid'      => null,
    ]);
}
