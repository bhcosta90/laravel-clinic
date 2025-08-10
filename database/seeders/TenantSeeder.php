<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

final class TenantSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function (): void {
            $this->call([
                PermissionSeeder::class,
                RoleSeeder::class,
                UserSeeder::class,
                CustomerSeeder::class,
                ProcedureSeeder::class,
                AgreementSeeder::class,
                PaymentMethodSeeder::class,
                FrequencySeeder::class,
                RemedySeeder::class,
                RoomSeeder::class,
                AnamnesisGroupSeeder::class,
                AnamnesisItemSeeder::class,
                TransactionSeeder::class,
                CommissionSeeder::class,
                AppointmentSeeder::class,
            ]);
        });
    }
}
