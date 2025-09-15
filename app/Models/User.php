<?php

declare(strict_types = 1);

namespace App\Models;

use App\Models\Traits\HashCode;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;

/**
 * @property string $name
 * @property string $email
 * @property string $password
 * @property Carbon $email_verified_at
 * @property string $remember_token
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
final class User extends Authenticatable
{
    use HasFactory;
    use HashCode;
    use Notifiable;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'password',
        'is_doctor',
        'has_fixed_hours',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function proceduresPerformed(): BelongsToMany
    {
        return $this->belongsToMany(Procedure::class, 'procedure_user', 'user_id', 'procedure_id')->withTimestamps();
    }

    public function specialties(): BelongsToMany
    {
        return $this->belongsToMany(Specialty::class, 'specialty_user', 'user_id', 'specialty_id')->withTimestamps();
    }

    public function permissions(): MorphToMany
    {
        return $this->morphToMany(Permission::class, 'model', $table = 'model_permission')
            ->withTimestamps()
            ->whereNull($table . '.deleted_at');
    }

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }
}
