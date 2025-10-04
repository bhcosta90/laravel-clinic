<?php

declare(strict_types = 1);

namespace Core\Shared\Domain\Validator;

use Core\Shared\Domain\Contracts\ValidatorAdapterInterface;
use Rakit\Validation\Validator as RakitValidator;

final readonly class RakitValidatorAdapter implements ValidatorAdapterInterface
{
    public function validate(array $data, array $rules): array
    {
        $validator  = new RakitValidator();
        $validation = $validator->make($data, $rules);
        $validation->validate();

        return $validation->fails() ? $validation->errors()->toArray() : [];
    }
}
