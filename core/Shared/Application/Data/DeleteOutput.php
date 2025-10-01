<?php

declare(strict_types = 1);

namespace Core\Shared\Application\Data;

final class DeleteOutput
{
    public function __construct(
        public bool $success,
        public string $message,
    ) {
    }
}
