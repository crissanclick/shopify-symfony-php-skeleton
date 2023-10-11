<?php

declare(strict_types=1);

namespace Crissanclick\App\Shared\Domain;

interface WebhookRepository
{
    public function register(Webhook $webhook): void;
}
