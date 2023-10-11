<?php

declare(strict_types=1);

namespace Crissanclick\App\Auth\Application\Session\Find;

use Crissanclick\App\Auth\Domain\Exception\ShopIsNotRegistered;
use Crissanclick\App\Auth\Domain\Persistence\SessionRepository;

class SessionRegistered
{
    public function __construct(private readonly SessionRepository $repository)
    {
    }

    public function has(string $shop): bool
    {
        try {
            return $this->repository->isStoreRegistered($shop);
        } catch (ShopIsNotRegistered) {
            return false;
        }
    }
}
