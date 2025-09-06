<?php

declare(strict_types = 1);

namespace App\Listeners\Catalog;

use App\Events\Catalog\DeletedEvent;

final class DeleteBarcodeListener
{
    public function __construct()
    {
    }

    public function handle(DeletedEvent $event): void
    {
        $catalog = $event->catalog;

        foreach ($catalog->packings as $packing) {
            $packing->forceDelete();
        }
    }
}
