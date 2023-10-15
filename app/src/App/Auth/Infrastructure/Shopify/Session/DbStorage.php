<?php

declare(strict_types=1);

namespace Crissanclick\App\Auth\Infrastructure\Shopify\Session;

use Crissanclick\App\Auth\Application\Session\Create\SessionCreator;
use Crissanclick\App\Auth\Application\Session\Delete\SessionRemover;
use Crissanclick\App\Auth\Application\Session\Find\SessionFinder;
use Crissanclick\App\Auth\Domain\Session as DomainSession;
use Crissanclick\App\Shared\Application\Session\CurrentSession;
use DateTime;
use Exception;
use Shopify\Auth\AccessTokenOnlineUserInfo;
use Shopify\Auth\Session;
use Shopify\Auth\SessionStorage;

class DbStorage implements SessionStorage
{
    public function __construct(
        private readonly SessionFinder $finder,
        private readonly SessionCreator $creator,
        private readonly SessionRemover $remover,
        private readonly CurrentSession $currentSession
    ) {
    }

    /**
     * Need to return a bool since the library expects it
     * Would be better to throw directly the exception
     *
     * @param Session $session
     * @return bool
     */
    public function storeSession(Session $session): bool
    {
        $currentSession = $this->finder->ask($session->getId());
        $onlineAccessInfo = $session->getOnlineAccessInfo();
        if (null !== $onlineAccessInfo) {
            $userId = $onlineAccessInfo->getId();
            $userFirstName = $onlineAccessInfo->getFirstName();
            $userLastName = $onlineAccessInfo->getLastName();
            $userEmail = $onlineAccessInfo->getEmail();
            $userEmailVerified = $onlineAccessInfo->isEmailVerified();
            $accountOwner = $onlineAccessInfo->isAccountOwner();
            $locale = $onlineAccessInfo->getLocale();
            $collaborator = $onlineAccessInfo->isCollaborator();
        }
        if ($currentSession) {
            $currentSession->update(
                $session->getAccessToken() ?? '',
                $session->getScope() ?? '',
                $session->getExpires(),
                $userId ?? 0,
                $session->getState(),
                $userFirstName ?? '',
                $userLastName ?? '',
                $userEmail ?? '',
                $userEmailVerified ?? false,
                $accountOwner ?? false,
                $locale ?? '',
                $collaborator ?? false,
                new DateTime()
            );
            $this->creator->execute($currentSession);
            return true;
        }

        $currentSession = DomainSession::create(
            0,
            $session->getId(),
            $session->getShop(),
            $session->isOnline(),
            $session->getState(),
            new DateTime(),
            new DateTime(),
            $session->getAccessToken() ?? '',
            $session->getExpires(),
            $session->getScope() ?? '',
            $userId ?? 0,
            $userFirstName ?? '',
            $userLastName ?? '',
            $userEmail ?? '',
            $userEmailVerified ?? false,
            $accountOwner ?? false,
            $locale ?? '',
            $collaborator ?? false
        );
        $this->creator->execute($currentSession);
        return true;
    }

    /**
     * @throws Exception
     */
    public function loadSession(string $sessionId): ?Session
    {
        $currentSession = $this->finder->ask($sessionId);
        if (null === $currentSession) {
            return null;
        }

        $session = new Session(
            $currentSession->sessionId,
            $currentSession->shop->value(),
            $currentSession->isOnline,
            $currentSession->state
        );
        if ($currentSession->expiresAt()) {
            $session->setExpires($currentSession->expiresAt());
        }
        if ($currentSession->accessToken()) {
            $session->setAccessToken($currentSession->accessToken()->value());
        }
        if ($currentSession->scope()) {
            $session->setScope($currentSession->scope());
        }
        if ($currentSession->isOnline) {
            $onlineAccessInfo = new AccessTokenOnlineUserInfo(
                $currentSession->userId(),
                $currentSession->userFirstName(),
                $currentSession->userLastName(),
                $currentSession->userEmail(),
                $currentSession->userEmailVerified(),
                $currentSession->accountOwner(),
                $currentSession->locale(),
                $currentSession->collaborator()
            );
            $session->setOnlineAccessInfo($onlineAccessInfo);
        }

        $this->currentSession->register(
            $currentSession->shop->value(),
            $currentSession->accessToken()->value()
        );

        return $session;
    }

    public function deleteSession(string $sessionId): bool
    {
        return true;
    }
}
