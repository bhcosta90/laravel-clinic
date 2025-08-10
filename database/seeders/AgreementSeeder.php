<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Agreement;
use Illuminate\Database\Seeder;

final class AgreementSeeder extends Seeder
{
    public function run(): void
    {
        Agreement::factory(25)->create();
    }
}
