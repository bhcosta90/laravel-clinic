<?php

declare(strict_types = 1);

namespace Core\Shared\Application\Exception;

use Exception;
use Throwable;

abstract class BaseException extends Exception
{
    public function __construct(string $message = '', int $code = 400, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
