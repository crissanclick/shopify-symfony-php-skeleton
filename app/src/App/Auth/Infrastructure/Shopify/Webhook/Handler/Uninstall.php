<?php

declare(strict_types=1);

namespace Crissanclick\App\Auth\Infrastructure\Shopify\Webhook\Handler;

use Crissanclick\App\Auth\Application\Session\Delete\SessionRemover;
use Crissanclick\App\Shared\Domain\WebhookHandler;
use Shopify\Webhooks\Handler;

class Uninstall implements Handler, WebhookHandler
{
    public function __construct(private readonly SessionRemover $sessionRemover)
    {
    }

    public function handle(string $topic, string $shop, array $body): void
    {
        $this->sessionRemover->execute($shop);
    }
}
