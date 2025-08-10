<?php

declare(strict_types = 1);

namespace Database\Seeders;

use App\Models\Agreement;
use App\Models\Appointment;
use App\Models\Customer;
use App\Models\Procedure;
use App\Models\User;
use Illuminate\Database\Seeder;

final class AppointmentSeeder extends Seeder
{
    public function run(): void
    {
        $usersId      = User::whereIsEmployee(true)->pluck('id')->toArray();
        $customersId  = Customer::pluck('id')->toArray();
        $proceduresId = Procedure::pluck('id')->toArray();
        $agreementsId = Agreement::pluck('id')->toArray();

        Appointment::factory(100)->make()->each(function ($item) use ($usersId, $proceduresId, $customersId, $agreementsId): void {
            $item->user_id      = collect($usersId)->random();
            $item->procedure_id = collect($proceduresId)->random();
            $item->customer_id  = collect($customersId)->random();
            $item->agreement_id = fake()->boolean() ? collect($agreementsId)->random() : null;
            $item->save();
        });

        Appointment::factory(5)->make()->each(function ($item) use ($usersId, $proceduresId, $customersId, $agreementsId): void {
            $item->date         = now();
            $item->user_id      = collect($usersId)->random();
            $item->procedure_id = collect($proceduresId)->random();
            $item->customer_id  = collect($customersId)->random();
            $item->agreement_id = fake()->boolean() ? collect($agreementsId)->random() : null;
            $item->save();
        });
    }
}
