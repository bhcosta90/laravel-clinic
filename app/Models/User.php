<?php

declare(strict_types = 1);

namespace App\Models;

use App\Casts\OnlyNumberCast;
use App\Enums\Models\Permission\Can;
use App\Observers\ClearCacheObserver;
use App\Traits\Models\CastsDatesToUserTimezone;
use App\Traits\Models\HashCode;
use App\Traits\Models\NodeTrait;
use App\Traits\Models\TenantTrait;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cache;
use OwenIt\Auditing\Contracts\Auditable;

#[ObservedBy([ClearCacheObserver::class])]
final class User extends Authenticatable implements Auditable
{
    use CastsDatesToUserTimezone;
    use HasFactory;
    use HashCode;
    use NodeTrait;
    use Notifiable;
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;
    use TenantTrait;

    protected $fillable = [
        'tenant_id',
        'name',
        'email',
        'role_id',
        'password',
        'address',
        'is_super_admin',
        'cellphone',
        'commission',
        'payment_data',
        'is_employee',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'cellphone' => OnlyNumberCast::class,
        'password'  => 'hashed',
    ];

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function permissions(): MorphToMany
    {
        return $this->morphToMany(Permission::class, 'model', $table = 'model_permissions')
            ->withTimestamps()
            ->whereNull($table . '.deleted_at');
    }

    public function hasPermissionTo(string | Can $role): bool
    {
        if ($role instanceof Can) {
            $role = $role->value;
        }

        $response = $this->role?->hasPermissionTo($role) ?: false;

        if (!$response) {
            $permissions = Cache::remember(
                config('cache.times.permission_prefix') . $this->getTable() . ".{$this->id}.permissions",
                config('cache.times.permission_time'),
                fn (): array => array_values(array_unique($this->permissions->pluck('slug')->toArray()))
            );

            $response = in_array($role, $permissions, true);

        }

        return $response;
    }

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }
}
