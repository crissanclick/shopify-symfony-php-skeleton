<?php

declare(strict_types=1);

namespace Crissanclick\Shared\Infrastructure\Symfony;

use Symfony\Component\HttpKernel\Event\ExceptionEvent;

class FallbackRoute
{
    public function onKernelException(ExceptionEvent $event): void
    {
        return;
    }
}
