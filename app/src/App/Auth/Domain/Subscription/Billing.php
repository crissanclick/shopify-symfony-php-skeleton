<?php

declare(strict_types=1);

namespace Crissanclick\App\Auth\Domain\Subscription;

interface Billing
{
    public function requestPayment(
        string $type,
        string $chargeName,
        string $returnUrl,
        float $amount,
        string $currencyCode,
        string $environment = 'production'
    ): ?string;
}
