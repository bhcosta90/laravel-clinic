<?php

namespace Core\Shared\Domain\Validator;

use Core\Shared\Domain\Contracts\ValidatorAdapterInterface;
use Rakit\Validation\Validator as RakitValidator;

class RakitValidatorAdapter implements ValidatorAdapterInterface
{
    public function validate(array $data, array $rules): array
    {
        $validator = new RakitValidator;
        $validation = $validator->make($data, $rules);
        $validation->validate();

        return $validation->fails() ? $validation->errors()->toArray() : [];
    }
}
