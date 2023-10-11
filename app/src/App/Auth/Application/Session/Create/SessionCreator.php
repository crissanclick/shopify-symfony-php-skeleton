<?php

declare(strict_types=1);

namespace Crissanclick\App\Auth\Application\Session\Create;

use Crissanclick\App\Auth\Domain\Persistence\SessionRepository;
use Crissanclick\App\Auth\Domain\Session;
use Crissanclick\Shared\Domain\Bus\Event\EventBus;

class SessionCreator
{
    public function __construct(
        private readonly SessionRepository $repository,
        private readonly EventBus $bus
    ) {
    }

    public function execute(Session $session): void
    {
        $this->repository->save($session);
        $this->bus->publish(...$session->pullDomainEvents());
    }
}
