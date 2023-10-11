<?php


declare(strict_types=1);

namespace Crissanclick\App\Shared\Domain;

use Crissanclick\Shared\Domain\Bus\Event\DomainEvent;

final class WebhookCreatedDomainEvent extends DomainEvent
{
    public function __construct(
        public readonly string $type,
        public readonly string $shop,
        public readonly string $token,
        string $eventId = null,
        string $occurredOn = null
    ) {
        parent::__construct($type, $eventId, $occurredOn);
    }

    public static function eventName(): string
    {
        return 'webhook.created';
    }

    public static function fromPrimitives(
        string $type,
        array $body,
        string $eventId,
        string $occurredOn
    ): DomainEvent {
        return new self($type, $body['shop'], $body['token'], $eventId, $occurredOn);
    }

    public function toPrimitives(): array
    {
        return [
            'type' => $this->type,
            'shop' => $this->shop
        ];
    }
}
