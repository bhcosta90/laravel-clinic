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
            WarehouseSeeder::class,
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
                SkuSeeder::class,
                PackingSeeder::class,
                LocationModuleSeeder::class,
                SectorSeeder::class,
            ]);
        }

        DB::transaction(fn () => $this->call($default));
    }
}
