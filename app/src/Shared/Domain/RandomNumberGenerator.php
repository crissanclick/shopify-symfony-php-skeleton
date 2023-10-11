<?php

declare(strict_types = 1);

namespace Crissanclick\Shared\Domain;

interface RandomNumberGenerator
{
    public function generate(): int;
}
