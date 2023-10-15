<?php

declare(strict_types=1);

namespace Crissanclick\App\Auth\Infrastructure\Shopify\Webhook;

use Crissanclick\App\Shared\Domain\Webhook;
use Crissanclick\App\Shared\Domain\WebhookHandler;
use Crissanclick\App\Auth\Infrastructure\Shopify\Webhook\Handler\Uninstall as UninstallHandler;

class Uninstall implements Webhook
{
    public function __construct(private readonly UninstallHandler $handler)
    {
    }

    public function type(): string
    {
        return 'APP_UNINSTALLED';
    }

    public function handler(): WebhookHandler
    {
        return $this->handler;
    }
}
