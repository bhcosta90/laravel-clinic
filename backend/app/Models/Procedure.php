<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\ProcedureFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

final class Procedure extends Model
{
    /** @use HasFactory<ProcedureFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
    ];
}
