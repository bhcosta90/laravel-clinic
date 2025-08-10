<?php

declare(strict_types=1);

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

            User::factory(23)->create();

            User::factory()->create([
                'id' => '1CRzgsDy2Rv4Po1JPS4CQX',
                'name'        => 'Test User',
                'email'       => 'test@example.com',
                'is_employee' => null,
                'role_id'     => $role->id,
            ]);

            User::factory()->create([
                'role_id'      => null,
                'name'         => 'Administrador de usuário',
                'email'        => 'test2@example.com',
                'is_employee'  => true,
                'commission'   => fake()->numberBetween(300, 1000) / 100,
                'payment_data' => str()->uuid(),
            ]);
        });
    }
}
