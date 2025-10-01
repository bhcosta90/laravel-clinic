<?php

declare(strict_types = 1);

namespace Core\Shared\Domain;

use Core\Shared\Domain\Contracts\ValidatorAdapterInterface;
use Core\Shared\Domain\Validator\FluentValidator;
use Core\Shared\Domain\Validator\RakitValidatorAdapter;
use DateTimeImmutable;
use Exception;
use Ramsey\Uuid\Uuid;

abstract class BaseDomain
{
    public readonly int | string $id;

    public DateTimeImmutable $createdAt;

    public DateTimeImmutable $updatedAt;

    // Adapter global (estático)
    private static ?ValidatorAdapterInterface $globalValidatorAdapter = null;

    // Adapter específico da instância (opcional)
    private ?ValidatorAdapterInterface $validatorAdapter = null;

    public function __construct(string | int | null $id = null)
    {
        $this->id        = $id ?: Uuid::uuid7()->toString();
        $this->createdAt = new DateTimeImmutable();
        $this->updatedAt = new DateTimeImmutable();

        $this->validatorAdapter = static::$globalValidatorAdapter ?: new RakitValidatorAdapter();
    }

    public function __get($property)
    {
        if (isset($this->{$property})) {
            return $this->{$property};
        }

        $className = get_class($this);

        throw new Exception("Property {$property} not found in class {$className}");
    }

    /**
     * Permite alterar o adapter **globalmente** para todas as Entities.
     */
    final public static function setGlobalValidatorAdapter(ValidatorAdapterInterface $adapter): void
    {
        static::$globalValidatorAdapter = $adapter;
    }

    protected function touch(): void
    {
        $this->updatedAt = new DateTimeImmutable();
    }

    protected function validator(): FluentValidator
    {
        return new FluentValidator($this->validatorAdapter);
    }
}
