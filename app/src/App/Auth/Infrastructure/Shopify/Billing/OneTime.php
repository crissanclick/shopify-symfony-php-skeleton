<?php

declare(strict_types=1);

namespace Crissanclick\App\Auth\Infrastructure\Shopify\Billing;

use Crissanclick\App\Auth\Application\Subscription\OneTimePayment;
use Crissanclick\App\Auth\Application\Subscription\OneTimePurchases;
use Crissanclick\App\Auth\Domain\Exception\SubscriptionIsAlreadyPaid;
use Crissanclick\App\Auth\Domain\Subscription\Billing;

class OneTime implements Billing
{
    public function __construct(
        private readonly OneTimePurchases $oneTimePurchases,
        private readonly OneTimePayment $oneTimePayment
    ) {
    }

    private static function type(): string
    {
        return 'one_time';
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
        if (self::type() !== $type) {
            return null;
        }
        $hasActivePayment = $this->hasActivePayment($chargeName);
        if (true === $hasActivePayment) {
            throw new SubscriptionIsAlreadyPaid();
        }

        return $this->oneTimePayment->pay(
            $chargeName,
            $amount,
            $returnUrl,
            $currencyCode,
            $environment
        );
    }

    private function hasActivePayment(string $chargeName): bool
    {
        $endCursor = null;
        do {
            $response = $this->oneTimePurchases->get(['endCursor' => $endCursor]);
            $purchases = $response['data']['currentAppInstallation']['oneTimePurchases'] ?? null;
            if (null === $purchases) {
                continue;
            }

            foreach ($purchases['edges'] as $purchase) {
                $node = $purchase['node'];
                if ($node['name'] === $chargeName && $node['status'] === 'ACTIVE') {
                    return true;
                }
            }

            $endCursor = $purchases['pageInfo']['endCursor'];
        } while ($purchases['pageInfo']['hasNextPage']);

        return false;
    }
}
