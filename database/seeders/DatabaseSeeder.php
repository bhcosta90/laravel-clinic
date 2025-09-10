<?php

declare(strict_types = 1);

namespace Database\Seeders;

use App\Models\Tenant;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Stancl\Tenancy\Exceptions\TenantDatabaseAlreadyExistsException;

final class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        try {
            $tenant = Tenant::create([
                'tenancy_db_name' => 'demo',
            ]);

            $tenant->domains()->create([
                'domain' => 'demo.localhost',
            ]);
        } catch (TenantDatabaseAlreadyExistsException) {
            //
        }
    }
}
