<?php

declare(strict_types=1);

namespace Crissanclick\App\Auth\Application\Session\Delete;

use Crissanclick\App\Auth\Domain\Persistence\SessionRepository;

class SessionRemover
{
    public function __construct(private readonly SessionRepository $repository)
    {
    }

    public function execute(string $shop): void
    {
        $this->repository->delete($shop);
    }
}
