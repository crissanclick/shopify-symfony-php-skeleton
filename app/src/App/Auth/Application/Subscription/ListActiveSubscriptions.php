<?php

declare(strict_types=1);

namespace Crissanclick\App\Auth\Application\Subscription;

use Crissanclick\App\Auth\Domain\Subscription\Persistence\SubscriptionRepository;
use Crissanclick\App\Auth\Domain\Subscription\Subscription;

final class ListActiveSubscriptions
{
    public function __construct(private readonly SubscriptionRepository $repository)
    {
    }

    public function get(): Subscription
    {
        return $this->repository->listActiveSubscriptions();
    }
}
