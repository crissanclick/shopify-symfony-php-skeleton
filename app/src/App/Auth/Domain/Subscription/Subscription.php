<?php

declare(strict_types=1);

namespace Crissanclick\App\Auth\Domain\Subscription;

class Subscription
{
    public function __construct(public readonly string $name)
    {
    }
}
