<?php

namespace Core\Shared\Domain\Contracts;

interface ValidatorAdapterInterface
{
    public function validate(array $data, array $rules): array;
}
