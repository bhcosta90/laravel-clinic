<?php

declare(strict_types = 1);

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Triage;
use Illuminate\Database\Seeder;

final class TriageSeeder extends Seeder
{
    public function run(): void
    {
        $customers = Customer::pluck('id')->toArray();
        Triage::factory(25)->make()->each(function ($item) use ($customers): void {
            $item->customer_id = collect($customers)->random();
            $item->save();
        });

    }
}
