<?php

declare(strict_types=1);

namespace Crissanclick\App\Shared\Application\Webhook\Create;

use Crissanclick\App\Shared\Domain\Webhook;
use Crissanclick\App\Shared\Domain\WebhookRepository;
use Crissanclick\Shared\Domain\Bus\Event\EventBus;

class WebhookRegistration
{
    public function __construct(
        private readonly WebhookRepository $repository,
        private readonly EventBus $bus
    ) {
    }

    public function register(string $type, string $shop, string $token): void
    {
        $webhook = Webhook::create($type, $shop, $token);
        $this->repository->register($webhook);
        $this->bus->publish(...$webhook->pullDomainEvents());
    }
}
