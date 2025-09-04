<?php

declare(strict_types = 1);

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Seeder;

final class PaymentMethodSeeder extends Seeder
{
    public function run(): void
    {
        PaymentMethod::factory(5)->create(['tenant_id' => DatabaseSeeder::TenantId]);
    }
}
