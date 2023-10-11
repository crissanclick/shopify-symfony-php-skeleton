<?php

declare(strict_types=1);

namespace Crissanclick\App\Auth\Domain\Persistence;

use Crissanclick\App\Auth\Domain\Exception\ShopIsNotRegistered;
use Crissanclick\App\Auth\Domain\Session;

interface SessionRepository
{
    public function save(Session $session): void;

    public function getBySessionId(string $sessionId): ?Session;

    public function get(int $id): ?Session;

    /**
     * @param string $shop
     * @return bool
     * @throws ShopIsNotRegistered
     */
    public function isStoreRegistered(string $shop): bool;

    public function delete(string $shop): void;
}
