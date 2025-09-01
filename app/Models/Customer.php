<?php

declare(strict_types = 1);

namespace App\Models;

use App\Abstracts\Model;
use App\Casts\OnlyNumberCast;
use Illuminate\Database\Eloquent\Casts\Attribute;

final class Customer extends Model
{
    protected $fillable = [
        'name',
        'birthday',
        'document',
    ];

    protected $casts = [
        'document' => OnlyNumberCast::class,
        'birthday' => 'date:Y-m-d',
    ];

    public function birthdayDescription(): Attribute
    {
        return Attribute::get(function (): string {
            $quantityYear  = abs((int) now()->diffInYears($this->birthday));
            $quantityMonth = abs((int) now()->diffInMonths($this->birthday));
            $quantityDays  = abs((int) now()->diffInDays($this->birthday));

            $message = trans_choice('birthday.year', $quantityYear, ['quantity' => $quantityYear]);

            if (0 === $quantityYear) {
                $message = trans_choice('birthday.month', $quantityYear, ['quantity' => $quantityMonth]);

                if (0 === $quantityMonth) {
                    $message = trans_choice('birthday.day', $quantityYear, ['quantity' => $quantityDays]);
                }
            }

            return $message;
        });
    }
}
