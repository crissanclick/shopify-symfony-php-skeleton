<?php

declare(strict_types=1);

namespace Crissanclick\App\Shared\Domain\Request;

interface Query
{
    public function get(): string;
}
