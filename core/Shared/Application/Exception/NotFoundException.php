<?php

namespace Core\Shared\Application\Exception;

class NotFoundException extends BaseException
{
    public function __construct(string $message = '')
    {
        parent::__construct($message, 404);
    }
}
