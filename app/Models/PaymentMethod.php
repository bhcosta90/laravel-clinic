<?php

declare(strict_types=1);

namespace App\Models;

use App\Abstracts\Model;

final class PaymentMethod extends Model
{
    protected $fillable = [
        'name',
        'tax',
    ];
}
