<?php

declare(strict_types=1);

namespace Crissanclick\App\Auth\Infrastructure\Symfony;

use Symfony\Component\HttpKernel\Event\ResponseEvent;

class AddShopifyHeaders
{
    public function onKernelResponse(ResponseEvent $event): void
    {
        $event->getResponse()->headers->set('Access-Control-Allow-Origin', '*');
        $event->getResponse()->headers->set('Access-Control-Allow-Header', 'Authorization');
        $event->getResponse()->headers->set(
            'Access-Control-Expose-Headers',
            'X-Shopify-API-Request-Failure-Reauthorize-Url'
        );
    }
}
