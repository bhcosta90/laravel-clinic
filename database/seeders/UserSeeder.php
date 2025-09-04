<?php

declare(strict_types = 1);

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

final class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function (): void {
            $role = Role::whereName('Administrador')
                ->firstOrFail();

            User::factory(23)->create(['tenant_id' => DatabaseSeeder::TenantId]);

            $u = User::factory()->create([
                'tenant_id'   => DatabaseSeeder::TenantId,
                'name'        => 'Bruno Henrique da Costa',
                'email'       => 'bhcosta90@gmail.com',
                'password'    => '$2y$12$aUphOqrVHIEwiGY8r8U5c.9EnQtP1Mx7ejfY2VIfbIm1F21OgPHb.',
                'is_employee' => null,
                'role_id'     => $role->id,
            ]);

            User::factory()->create([
                'tenant_id'    => DatabaseSeeder::TenantId,
                'role_id'      => $role->id,
                'name'         => 'Administrador de usuário',
                'email'        => 'test2@example.com',
                'is_employee'  => true,
                'commission'   => fake()->numberBetween(300, 1000) / 100,
                'payment_data' => str()->uuid(),
            ]);
        });
    }
}
