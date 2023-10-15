<?php

declare(strict_types=1);

namespace Crissanclick\App\Shared\Domain;

interface Webhook
{
    public function type(): string;

    public function handler(): WebhookHandler;
}
