<?php

declare(strict_types=1);

namespace Crissanclick\App\Auth\Infrastructure\Shopify;

use Crissanclick\App\Auth\Infrastructure\Shopify\Session\DbStorage;
use Crissanclick\App\Shared\Application\Webhook\Create\WebhookPoolHandlers;
use Shopify\Context;
use Shopify\Exception\MissingArgumentException;
use Symfony\Component\HttpKernel\Event\RequestEvent;

class Bootstrap
{
    public function __construct(
        private readonly DbStorage $storage,
        private readonly WebhookPoolHandlers $webhookPoolHandlers
    ) {
    }

    /**
     * @throws MissingArgumentException
     */
    public function onKernelRequest(RequestEvent $event): void
    {
        $host = $event->getRequest()->server->get('SERVER_NAME');
        Context::initialize(
            $event->getRequest()->server->get('SHOPIFY_API_KEY') ?? '',
            $event->getRequest()->server->get('SHOPIFY_API_SECRET') ?? '',
            $event->getRequest()->server->get('SHOPIFY_API_SCOPES') ?? '',
            $host,
            $this->storage
        );

        $this->webhookPoolHandlers->execute();
    }
}
