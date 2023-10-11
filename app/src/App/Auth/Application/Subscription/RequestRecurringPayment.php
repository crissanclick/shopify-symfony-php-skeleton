<?php

declare(strict_types=1);

namespace Crissanclick\App\Auth\Application\Subscription;

use Crissanclick\App\Auth\Domain\Subscription\Persistence\SubscriptionRepository;

class RequestRecurringPayment
{
    public function __construct(private readonly SubscriptionRepository $repository)
    {
    }

    public function pay(
        string $chargeName,
        string $interval,
        float $amount,
        string $currency,
        string $returnUrl,
        string $environment
    ): string {
        return $this->repository->payRecurring(
            $chargeName,
            $interval,
            $amount,
            $currency,
            $returnUrl,
            $environment
        );
    }
}
