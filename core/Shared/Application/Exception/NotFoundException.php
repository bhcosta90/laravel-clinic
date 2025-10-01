<?php

declare(strict_types = 1);

namespace Core\Shared\Application\Exception;

final readonly class NotFoundException extends BaseException
{
    public function __construct(string $message = '')
    {
        parent::__construct($message, 404);
    }
}
