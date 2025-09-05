<?php

declare(strict_types = 1);

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

final class RoleSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function (): void {
            $role = Role::create([
                'tenant_id' => DatabaseSeeder::TenantId,
                'name'      => 'Administrador',
                'children'  => [
                    ['name' => 'Testing', 'tenant_id' => DatabaseSeeder::TenantId],
                    ['name' => 'Clínico Geral', 'tenant_id' => DatabaseSeeder::TenantId],
                    ['name' => 'Recepcionista', 'tenant_id' => DatabaseSeeder::TenantId],
                    ['name' => 'Faxineira', 'tenant_id' => DatabaseSeeder::TenantId],
                    [
                        'name'      => 'Enfermeira',
                        'tenant_id' => DatabaseSeeder::TenantId,
                        'children'  => [
                            ['name' => 'Técnica de enfermagem', 'tenant_id' => DatabaseSeeder::TenantId],
                        ]],
                    ['name' => 'Fonoaudióloga', 'tenant_id' => DatabaseSeeder::TenantId],
                    ['name' => 'Cardiologista', 'tenant_id' => DatabaseSeeder::TenantId],
                    ['name' => 'Ortopedista', 'tenant_id' => DatabaseSeeder::TenantId],
                    ['name' => 'Neurologista', 'tenant_id' => DatabaseSeeder::TenantId],
                    ['name' => 'Otorrino', 'tenant_id' => DatabaseSeeder::TenantId],
                    ['name' => 'Pediatra', 'tenant_id' => DatabaseSeeder::TenantId],
                    ['name' => 'Psiquiatra', 'tenant_id' => DatabaseSeeder::TenantId],
                    ['name' => 'Psicólogo', 'tenant_id' => DatabaseSeeder::TenantId],
                    ['name' => 'Dermatologista', 'tenant_id' => DatabaseSeeder::TenantId],
                    ['name' => 'Urologista', 'tenant_id' => DatabaseSeeder::TenantId],
                    ['name' => 'Ginecologista', 'tenant_id' => DatabaseSeeder::TenantId],
                    ['name' => 'Gastro', 'tenant_id' => DatabaseSeeder::TenantId],
                    ['name' => 'Técnica em Laboratório', 'tenant_id' => DatabaseSeeder::TenantId],
                    ['name' => 'Ultrassom', 'tenant_id' => DatabaseSeeder::TenantId],
                ],
            ]);

            foreach (Permission::all() as $permission) {
                $role->permissions()->attach($permission->id);
            }
            $role->touch();
        });
    }
}
