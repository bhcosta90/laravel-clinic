<?php

declare(strict_types = 1);

namespace Core\Shared\Domain\Validator;

use Core\Shared\Domain\Contracts\ValidatorAdapterInterface;
use Core\Shared\Domain\Exception\ValidationException;

final class FluentValidator
{
    private array $data = [];

    private array $rules = [];

    private ?string $currentField = null;

    private ValidatorAdapterInterface $adapter;

    public function __construct(?ValidatorAdapterInterface $adapter = null)
    {
        // Por padrão, usa Rakit
        $this->adapter = $adapter ?? new RakitValidatorAdapter();
    }

    public function data(array $data): self
    {
        $this->data = $data;

        return $this;
    }

    public function field(string $field): self
    {
        $this->currentField = $field;

        if (!isset($this->rules[$field])) {
            $this->rules[$field] = [];
        }

        return $this;
    }

    public function required(): self
    {
        $this->rules[$this->currentField][] = 'required';

        return $this;
    }

    public function min(int $length): self
    {
        $this->rules[$this->currentField][] = "min:$length";

        return $this;
    }

    public function max(int $length): self
    {
        $this->rules[$this->currentField][] = "max:$length";

        return $this;
    }

    public function email(): self
    {
        $this->rules[$this->currentField][] = 'email';

        return $this;
    }

    // Adiciona outras regras conforme necessidade...

    /**
     * @throws ValidationException
     */
    public function validate(array $moreErrors = []): void
    {
        $errors = $this->adapter->validate($this->data, $this->rules) + $moreErrors;

        if (!empty($errors)) {
            throw new ValidationException($errors);
        }
    }
}
