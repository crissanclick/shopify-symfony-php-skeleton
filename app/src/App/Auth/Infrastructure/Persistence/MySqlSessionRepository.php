<?php

declare(strict_types=1);

namespace Crissanclick\App\Auth\Infrastructure\Persistence;

use Crissanclick\App\Auth\Domain\Exception\ShopIsNotRegistered;
use Crissanclick\App\Auth\Domain\Persistence\SessionRepository;
use Crissanclick\App\Auth\Domain\Session;
use Crissanclick\Shared\Infrastructure\Persistence\Doctrine\DoctrineRepository;
use Doctrine\Common\Collections\Criteria;

class MySqlSessionRepository extends DoctrineRepository implements SessionRepository
{
    public function save(Session $session): void
    {
        $this->persist($session);
    }

    public function getBySessionId(string $sessionId): ?Session
    {
        return $this->repository(Session::class)->findOneBy(['sessionId' => $sessionId]);
    }

    public function get(int $id): ?Session
    {
        return $this->repository(Session::class)->findOneBy(['id' => $id]);
    }

    public function getByShop(string $shopId): ?Session
    {
        return $this->repository(Session::class)->findOneBy(['shop.value' => $shopId]);
    }

    /**
     * @throws ShopIsNotRegistered
     */
    public function isStoreRegistered(string $shop): bool
    {
        $criteria = new Criteria();
        $criteria->where(Criteria::expr()->eq('shop.value', $shop));
        $criteria->andWhere(Criteria::expr()->neq('accessToken.value', ''));
        $session = $this->repository(Session::class)->matching($criteria);

        if (false === $session->first()) {
            throw new ShopIsNotRegistered('Shop ' . $shop . ' is not registered yet.');
        }
        return true;
    }

    public function delete(string $shop): void
    {
        $this->remove($this->getByShop($shop));
    }
}
