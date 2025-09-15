<?php

declare(strict_types = 1);

namespace Database\Factories;

use App\Models\ModelPermission;
use App\Models\Permission;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

final class ModelPermissionFactory extends Factory
{
    protected $model = ModelPermission::class;

    public function definition(): array
    {
        return [
            'created_at' => Carbon::now(), //
            'updated_at' => Carbon::now(),

            'permission_id' => Permission::factory(),
        ];
    }
}
