<?php

declare(strict_types=1);

namespace Crissanclick\App\Auth\Application\Subscription;

use Crissanclick\App\Auth\Domain\Subscription\Persistence\SubscriptionRepository;

class RecurringPurchases
{
    public function __construct(private readonly SubscriptionRepository $repository)
    {
    }

    public function get(): array
    {
        return $this->repository->recurringPurchases();
    }
}
