<?php

declare(strict_types = 1);

namespace Crissanclick\Shared\Infrastructure;

use Crissanclick\Shared\Domain\RandomNumberGenerator;

final class PhpRandomNumberGenerator implements RandomNumberGenerator
{
    public function generate(): int
    {
        return random_int(1, 5);
    }
}
