<?php

namespace Core\Shared\Application\Data;

class DeleteOutput
{
    public function __construct(
        public bool $success,
        public string $message,
    ) {}
}
