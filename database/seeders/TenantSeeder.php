<?php

declare(strict_types = 1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

final class TenantSeeder extends Seeder
{
    public function run(): void
    {
        $default = [
            PermissionSeeder::class,
            RoleSeeder::class,
        ];

        if (app()->isLocal()) {
            $default = array_merge($default, [
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
                TriageSeeder::class,
                CatalogSeeder::class,
            ]);
        }

        DB::transaction(function () use ($default) {
            $this->call($default);
        });
    }
}
