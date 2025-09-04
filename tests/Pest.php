<?php

declare(strict_types = 1);

use App\Models\Appointment;
use App\Models\Customer;
use App\Models\Procedure;
use App\Models\Tenant;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

pest()->extend(Tests\TestCase::class)
    ->use(Illuminate\Foundation\Testing\LazilyRefreshDatabase::class)
    ->in('Feature');

// expect()->extend('toBeOne', fn () => $this->toBe(1));

function makeUser(): User
{
    $tenant = Tenant::factory()->create([
        'id' => DatabaseSeeder::TenantId,
    ]);
    $user = User::factory()->create(['is_employee' => true, 'tenant_id' => $tenant->id]);
    Auth::login($user);

    return $user;
}

function makeAppointment(User $user, array $data = []): Appointment
{
    return Appointment::factory()->create($data + [
        'tenant_id'    => tenant()->id,
        'user_id'      => $user->id,
        'customer_id'  => $data['customer_id'] ?? Customer::factory()->create()->id,
        'procedure_id' => $data['procedure_id'] ?? Procedure::factory()->create()->id,
        'agreement_id' => null,
        'date'         => when($data['date'], Carbon::parse($data['date'])),
        'is_return'    => false,
        'status'       => null,
        'is_paid'      => null,
    ]);
}

function dumpTable(string $table, array $fields = ['*']): void
{
    dump([
        $table,
        Illuminate\Support\Facades\DB::table($table)->get($fields)->toArray(),
    ]);
}

function ddTable(string $table, array $fields = ['*']): void
{
    dd([
        $table,
        Illuminate\Support\Facades\DB::table($table)->get($fields)->toArray(),
    ]);
}

function enableQuery(): void
{
    DB::listen(function ($query): void {
        dump([
            $query->sql,
            $query->bindings,
        ]);
    });
}
