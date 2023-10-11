<?php

declare(strict_types=1);

namespace Crissanclick\App\Shared\Domain;

use Crissanclick\Shared\Domain\Aggregate\AggregateRoot;

class Webhook extends AggregateRoot
{
    public function __construct(
        public readonly string $type,
        public readonly string $shop,
        public readonly AccessToken $token
    ) {
    }

    public static function create(string $type, string $shop, string $token): self
    {
        $webhook = new self(
            $type,
            $shop,
            new AccessToken($token)
        );

        $webhook->record(
            new WebhookCreatedDomainEvent(
                $webhook->type,
                $webhook->shop,
                $webhook->token->value()
            )
        );

        return $webhook;
    }
}
