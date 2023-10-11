<?php

declare(strict_types=1);

namespace Crissanclick\App\Auth\Domain\Subscription\Persistence;

use Crissanclick\App\Auth\Domain\Subscription\Subscription;

interface SubscriptionRepository
{
    public function listActiveSubscriptions(): Subscription;

    public function oneTimePurchases(array $parameters): array;

    public function recurringPurchases(): array;

    public function payRecurring(
        string $chargeName,
        string $interval,
        float $amount,
        string $currency,
        string $returnUrl,
        string $environment
    ): string;

    public function payOneTime(
        string $name,
        float $amount,
        string $returnUrl,
        string $currency,
        string $environment
    ): ?string;
}
