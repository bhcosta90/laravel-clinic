<?php

declare(strict_types = 1);

namespace Database\Seeders;

use App\Models\Remedy;
use Illuminate\Database\Seeder;

final class RemedySeeder extends Seeder
{
    public function run(): void
    {
        Remedy::factory(25)->create();
    }
}
