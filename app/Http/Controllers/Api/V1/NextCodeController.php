<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Api\V1;

use Exception;

final class NextCodeController
{
    public function __invoke(string $type)
    {
        $singular = str($type)->singular()->ucfirst()->value();

        $typeHandler = $singular . ' next code handler';
        $classHandle = str($typeHandler)->camel()->ucfirst()->value();
        $handleClass = 'Core\\Application\\Handler\\' . $singular . '\\' . $classHandle;

        if (class_exists($handleClass)) {
            return response()->json([
                'data' => [
                    'code' => app($handleClass)->execute(),
                ],
            ]);
        }

        throw new Exception(sprintf('Handler %s not found', $handleClass));
    }
}
