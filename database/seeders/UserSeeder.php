<?php

declare(strict_types = 1);

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

final class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function (): void {
            User::factory()->create([
                'name'     => 'Bruno Costa',
                'email'    => 'bhcosta90@gmail.com',
                'password' => '$2y$12$2IQL/I8rUZdt2I9Y6whFh.VAZa12/S6MxZ5AKUOs3BxVjHMhYEHP.',
            ]);

            User::factory()->create([
                'name'     => 'Usuário de demonstração',
                'email'    => 'demo@test.com',
                'password' => 'password',
            ]);

            User::factory(23)->create();
        });
    }
}
