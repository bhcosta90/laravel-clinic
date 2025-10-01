<?php

namespace Core\Shared\Domain\Exception;

use Core\Shared\Application\Exception\BaseException;

class ValidationException extends BaseException
{
    private array $errors = [];

    public function __construct(array $errors)
    {
        parent::__construct('Validation errors found.', 422);
        $this->errors = $errors;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}
