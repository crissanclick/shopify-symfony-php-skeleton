<?php

declare(strict_types=1);

namespace Crissanclick\App\Shared\Infrastructure\Shopify;

use Crissanclick\App\Auth\Infrastructure\Shopify\Session\DbStorage;
use Crissanclick\App\Auth\Infrastructure\Shopify\Webhook\Handler\Uninstall;
use Shopify\Context;
use Shopify\Exception\MissingArgumentException;
use Shopify\Webhooks\Registry;
use Shopify\Webhooks\Topics;
use Symfony\Component\HttpKernel\Event\RequestEvent;

class Bootstrap
{
    public function __construct(
        private readonly DbStorage $storage,
        private readonly Uninstall $uninstallHandler
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

        Registry::addHandler(Topics::APP_UNINSTALLED, $this->uninstallHandler);
    }
}
