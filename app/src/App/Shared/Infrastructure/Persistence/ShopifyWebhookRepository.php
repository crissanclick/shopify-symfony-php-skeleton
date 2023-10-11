<?php

declare(strict_types=1);

namespace Crissanclick\App\Shared\Infrastructure\Persistence;

use Crissanclick\App\Shared\Domain\Webhook;
use Crissanclick\App\Shared\Domain\WebhookRepository;
use Psr\Http\Client\ClientExceptionInterface;
use Shopify\Exception\InvalidArgumentException;
use Shopify\Exception\UninitializedContextException;
use Shopify\Exception\WebhookRegistrationException;
use Shopify\Webhooks\Registry;

class ShopifyWebhookRepository implements WebhookRepository
{
    private const WEBHOOK_RESOLVE_URL = '/api/webhooks';

    /**
     * @throws InvalidArgumentException
     * @throws ClientExceptionInterface
     * @throws UninitializedContextException
     * @throws WebhookRegistrationException
     */
    public function register(Webhook $webhook): void
    {
        Registry::register(
            self::WEBHOOK_RESOLVE_URL,
            $webhook->type,
            $webhook->shop,
            $webhook->token->value()
        );
    }
}
