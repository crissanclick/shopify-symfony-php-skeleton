<?php

declare(strict_types=1);

namespace Crissanclick\App\Shared\Domain\Request;

interface Mutation
{
    public function mutation(): string;
}
