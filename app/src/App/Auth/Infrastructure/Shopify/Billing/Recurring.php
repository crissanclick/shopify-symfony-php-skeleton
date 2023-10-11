<?php

declare(strict_types=1);

namespace Crissanclick\App\Auth\Infrastructure\Shopify\Billing;

use Crissanclick\App\Auth\Application\Subscription\RecurringPurchases;
use Crissanclick\App\Auth\Application\Subscription\RequestRecurringPayment;
use Crissanclick\App\Auth\Domain\Exception\SubscriptionIsAlreadyPaid;
use Crissanclick\App\Auth\Domain\Subscription\Billing;

class Recurring implements Billing
{
    private const INTERVAL_TYPES = [
        'recurring' => [
            'every_30_days',
            'annual'
        ]
    ];

    public function __construct(
        private readonly RecurringPurchases $recurringPurchases,
        private readonly RequestRecurringPayment $recurringPayment
    ) {
    }

    private static function type(): string
    {
        return 'recurring';
    }

    /**
     * @throws SubscriptionIsAlreadyPaid
     */
    public function requestPayment(
        string $type,
        string $chargeName,
        string $returnUrl,
        float $amount,
        string $currencyCode,
        string $environment = 'production'
    ): ?string {
        if (in_array($type, self::INTERVAL_TYPES[self::type()] ?? [], true) === false) {
            return null;
        }
        $hasActivePayment = $this->hasActiveSubscription($environment, $chargeName);
        if (true === $hasActivePayment) {
            throw new SubscriptionIsAlreadyPaid();
        }

        return $this->recurringPayment->pay(
            $chargeName,
            strtoupper($type),
            $amount,
            $currencyCode,
            $returnUrl,
            $environment
        );
    }

    private function hasActiveSubscription(string $environment, string $chargeName): bool
    {
        $response = $this->recurringPurchases->get();
        $subscriptions = $response['data']['currentAppInstallation']['activeSubscriptions'] ?? null;
        foreach ($subscriptions as $subscription) {
            if ($subscription['name'] === $chargeName && $environment !== 'test') {
                return true;
            }
        }

        return false;
    }
}
