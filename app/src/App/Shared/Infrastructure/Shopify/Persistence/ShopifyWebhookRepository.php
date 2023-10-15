<?php

declare(strict_types=1);

namespace Crissanclick\App\Shared\Infrastructure\Shopify\Persistence;

use Crissanclick\App\Shared\Application\Session\CurrentSession;
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

    public function __construct(private readonly CurrentSession $session)
    {
    }

    /**
     * @throws InvalidArgumentException
     * @throws ClientExceptionInterface
     * @throws UninitializedContextException
     * @throws WebhookRegistrationException
     */
    public function register(Webhook $webhook): void
    {
        $session = $this->session->get();
        if (null === $session || '' === $session->accessToken->value()) {
            return; //webhooks can not be registered without session
        }

        Registry::register(
            self::WEBHOOK_RESOLVE_URL,
            $webhook->type(),
            $session->shop->value(),
            $session->accessToken->value()
        );
    }

    public function addHandler(Webhook $webhook): void
    {
        Registry::addHandler($webhook->type(), $webhook->handler());
    }
}
