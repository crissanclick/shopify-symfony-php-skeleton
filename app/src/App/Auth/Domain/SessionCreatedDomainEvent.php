<?php


declare(strict_types=1);

namespace Crissanclick\App\Auth\Domain;

use Crissanclick\Shared\Domain\Bus\Event\DomainEvent;

final class SessionCreatedDomainEvent extends DomainEvent
{
    public function __construct(
        public readonly string $id,
        public readonly string $shopId,
        public readonly string $accessToken,
        string $eventId = null,
        string $occurredOn = null
    ) {
        parent::__construct($id, $eventId, $occurredOn);
    }

    public static function eventName(): string
    {
        return 'session.created';
    }

    public static function fromPrimitives(
        string $aggregateId,
        array $body,
        string $eventId,
        string $occurredOn
    ): DomainEvent {
        return new self($aggregateId, $body['shopId'], $body['accessToken'], $eventId, $occurredOn);
    }

    public function toPrimitives(): array
    {
        return [
            'shop' => $this->shopId,
            'token' => $this->accessToken,
        ];
    }
}
