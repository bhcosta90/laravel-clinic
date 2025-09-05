<?php

declare(strict_types = 1);

namespace Database\Seeders;

use App\Models\Procedure;
use Illuminate\Database\Seeder;

final class ProcedureSeeder extends Seeder
{
    public function run(): void
    {
        Procedure::factory(25)->create();
    }
}
