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
                'name'     => 'Administrador',
                'children' => [
                    ['name' => 'Testing'],
                    ['name' => 'Clínico Geral'],
                    ['name' => 'Recepcionista'],
                    ['name' => 'Faxineira'],
                    [
                        'name'     => 'Enfermeira',
                        'children' => [
                            ['name' => 'Técnica de enfermagem'],
                        ]],
                    ['name' => 'Fonoaudióloga'],
                    ['name' => 'Cardiologista'],
                    ['name' => 'Ortopedista'],
                    ['name' => 'Neurologista'],
                    ['name' => 'Otorrino'],
                    ['name' => 'Pediatra'],
                    ['name' => 'Psiquiatra'],
                    ['name' => 'Psicólogo'],
                    ['name' => 'Dermatologista'],
                    ['name' => 'Urologista'],
                    ['name' => 'Ginecologista'],
                    ['name' => 'Gastro'],
                    ['name' => 'Técnica em Laboratório'],
                    ['name' => 'Ultrassom'],
                ],
            ]);

            foreach (Permission::all() as $permission) {
                $role->permissions()->attach($permission->id);
            }
            $role->touch();
        });
    }
}
