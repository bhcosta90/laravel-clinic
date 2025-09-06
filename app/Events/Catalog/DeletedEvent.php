<?php

declare(strict_types = 1);

namespace App\Events\Catalog;

use App\Models\Catalog;
use Illuminate\Foundation\Events\Dispatchable;

final class DeletedEvent
{
    use Dispatchable;

    public function __construct(public Catalog $catalog)
    {
    }
}
