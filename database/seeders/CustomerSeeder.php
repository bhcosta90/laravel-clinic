<?php

declare(strict_types = 1);

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Seeder;

final class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        Customer::factory(25)->create();

        $date = fake()->dateTimeBetween(now()->subYears(18), now()->subYears(10));

        Customer::factory(5)->create([
            'birthday' => $date
                ->setDate(
                    year: (int) $date->format('Y'),
                    month: (int) date('m'),
                    day: (int) $date->format('d')
                ),
        ]);

        Customer::factory(5)->create([
            'birthday' => $date
                ->setDate(
                    year: (int) $date->format('Y'),
                    month: (int) date('m'),
                    day: (int) date('d')
                ),
        ]);
    }
}
