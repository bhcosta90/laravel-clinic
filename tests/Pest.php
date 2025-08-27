<?php

declare(strict_types = 1);

use App\Models\Appointment;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

use function Pest\Laravel\actingAs;

pest()->extend(Tests\TestCase::class)
    ->use(Illuminate\Foundation\Testing\LazilyRefreshDatabase::class)
    ->in('Feature');

expect()->extend('toBeOne', fn () => $this->toBe(1));

function makeUser(): User
{
    $user = User::factory()->create(['is_employee' => true]);
    Auth::login($user);
    actingAs($user);

    return $user;
}

function makeAppointment(User $user, string $dateTime): Appointment
{
    return Appointment::factory()->create([
        'user_id'      => $user->id,
        'agreement_id' => null,
        'date'         => Carbon::parse($dateTime),
        'is_return'    => false,
        'status'       => null,
        'is_paid'      => null,
    ]);
}
