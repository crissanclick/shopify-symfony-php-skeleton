<?php

declare(strict_types=1);

namespace Crissanclick\App\Auth\Application\Session\Find;

use Crissanclick\App\Auth\Domain\Persistence\SessionRepository;
use Crissanclick\App\Auth\Domain\Session;

class SessionFinder
{
    public function __construct(private readonly SessionRepository $repository)
    {
    }

    public function ask(string $sessionId): ?Session
    {
        return $this->repository->getBySessionId($sessionId);
    }
}
