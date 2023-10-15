<?php

declare(strict_types=1);

namespace Crissanclick\App\Shared\Application\Webhook\Create;

use Crissanclick\App\Shared\Domain\Webhook;
use Crissanclick\App\Shared\Domain\WebhookRepository;
use Crissanclick\Shared\Domain\Bus\Event\EventBus;

class WebhookPoolRegistration
{
    public function __construct(
        private readonly iterable $webhooks,
        private readonly WebhookRepository $repository
    ) {
    }

    public function register(): void
    {
        foreach ($this->webhooks as $webhook) {
            $this->repository->register($webhook);
        }
    }
}
