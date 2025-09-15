<?php

declare(strict_types = 1);

namespace App\Models;

use App\Models\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

final class Role extends Model
{
    protected $fillable = [
        'name',
    ];

    public function permissions(): MorphToMany
    {
        return $this->morphToMany(Permission::class, 'model', $table = 'model_permission')
            ->withTimestamps()
            ->whereNull($table . '.deleted_at');
    }
}
