<?php

declare(strict_types = 1);

namespace Crissanclick\Shared\Domain;

interface UuidGenerator
{
    public function generate(): string;
}
