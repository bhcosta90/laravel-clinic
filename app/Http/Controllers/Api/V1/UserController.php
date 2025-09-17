<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Api\V1;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use QuantumTecnology\ControllerBasicsExtension\Traits\AsGraphQLController;

final class UserController
{
    use AsGraphQLController;

    protected function allowedFields(): array
    {
        return [
            'id',
            'name',
            'email',
            'created_at',
            'updated_at',
        ];
    }

    protected function model(): Model
    {
        return new User();
    }
}
