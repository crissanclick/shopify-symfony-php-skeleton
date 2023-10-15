<?php

declare(strict_types=1);

namespace Crissanclick\App\Shared\Application\Webhook\Create;

use Crissanclick\App\Shared\Domain\WebhookRepository;

class WebhookPoolHandlers
{
    public function __construct(
        private readonly iterable $webhooks,
        private readonly WebhookRepository $repository
    ) {
    }

    public function execute(): void
    {
        foreach ($this->webhooks as $webhook) {
            $this->repository->addHandler($webhook);
        }
    }
}
