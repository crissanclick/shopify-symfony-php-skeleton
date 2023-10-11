<?php

declare(strict_types=1);

namespace Crissanclick\App\Auth\Application\Subscription;

use Crissanclick\App\Auth\Domain\Subscription\Persistence\SubscriptionRepository;

class OneTimePayment
{
    public function __construct(private readonly SubscriptionRepository $repository)
    {
    }

    public function pay(
        string $name,
        float $amount,
        string $returnUrl,
        string $currency,
        string $environment
    ): string {
        return $this->repository->payOneTime($name, $amount, $returnUrl, $currency, $environment);
    }
}
