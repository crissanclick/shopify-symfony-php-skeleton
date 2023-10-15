<?php

declare(strict_types=1);

namespace Crissanclick\App\Shared\Infrastructure\Symfony;

use Crissanclick\App\Shared\Application\Webhook\Create\WebhookPoolRegistration;
use Symfony\Component\HttpKernel\Event\ResponseEvent;

class WebhookRegistration
{
    public function __construct(private readonly WebhookPoolRegistration $webhookPoolRegistration)
    {
    }

    public function onKernelResponse(ResponseEvent $event): void
    {
        $this->webhookPoolRegistration->register();
    }
}
