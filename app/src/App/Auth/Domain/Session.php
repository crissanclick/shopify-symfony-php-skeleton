<?php

declare(strict_types=1);

namespace Crissanclick\App\Auth\Domain;

use Crissanclick\App\Shared\Domain\AccessToken;
use Crissanclick\App\Shared\Domain\ShopId;
use Crissanclick\Shared\Domain\Aggregate\AggregateRoot;
use DateTime;

class Session extends AggregateRoot
{
    private function __construct(
        public int $id,
        public readonly string $sessionId,
        public readonly ShopId $shop,
        public readonly bool $isOnline,
        public string $state,
        private AccessToken $accessToken,
        private ?DateTime $expiresAt,
        private string $scope,
        private int $userId,
        private string $userFirstName,
        private string $userLastName,
        private string $userEmail,
        private bool $userEmailVerified,
        private bool $accountOwner,
        private string $locale,
        private bool $collaborator,
        public ?DateTime $createdAt,
        private ?DateTime $updatedAt
    ) {
    }

    public static function create(
        int $id,
        string $sessionId,
        string $shop,
        bool $isOnline,
        string $state,
        ?DateTime $createdAt,
        ?DateTime $updatedAt,
        string $accessToken,
        ?DateTime $expiresAt,
        string $scope,
        int $userId,
        string $userFirstName,
        string $userLastName,
        string $userEmail,
        bool $userEmailVerified,
        bool $accountOwner,
        string $locale,
        bool $collaborator
    ): self {
        $session = new self(
            $id,
            $sessionId,
            new ShopId($shop),
            $isOnline,
            $state,
            new AccessToken($accessToken),
            $expiresAt,
            $scope,
            $userId,
            $userFirstName,
            $userLastName,
            $userEmail,
            $userEmailVerified,
            $accountOwner,
            $locale,
            $collaborator,
            $createdAt,
            $updatedAt,
        );
        $session->record(
            new SessionCreatedDomainEvent($sessionId, $shop, $accessToken)
        );

        return $session;
    }

    public function update(
        string $accessToken,
        string $scope,
        ?DateTime $expiresAt,
        int $userId,
        string $state,
        string $userFirstName,
        string $userLastName,
        string $userEmail,
        bool $userEmailVerified,
        bool $accountOwner,
        string $locale,
        bool $collaborator,
        ?DateTime $updatedAt
    ): void {
        $this->accessToken = new AccessToken($accessToken);
        $this->scope = $scope;
        $this->expiresAt = $expiresAt;
        $this->userId = $userId;
        $this->state = $state;
        $this->userFirstName = $userFirstName;
        $this->userLastName = $userLastName;
        $this->userEmail = $userEmail;
        $this->userEmailVerified = $userEmailVerified;
        $this->accountOwner = $accountOwner;
        $this->locale = $locale;
        $this->collaborator = $collaborator;
        $this->updatedAt = $updatedAt;
    }

    public function expiresAt(): ?DateTime
    {
        return $this->expiresAt;
    }

    public function accessToken(): AccessToken
    {
        return $this->accessToken;
    }

    public function userId(): int
    {
        return $this->userId;
    }

    public function userFirstName(): string
    {
        return $this->userFirstName;
    }

    public function userLastName(): string
    {
        return $this->userLastName;
    }

    public function userEmail(): string
    {
        return $this->userEmail;
    }

    public function userEmailVerified(): bool
    {
        return $this->userEmailVerified;
    }

    public function accountOwner(): bool
    {
        return $this->accountOwner;
    }

    public function locale(): string
    {
        return $this->locale;
    }

    public function collaborator(): bool
    {
        return $this->collaborator;
    }

    public function updatedAt(): ?DateTime
    {
        return $this->updatedAt;
    }

    public function scope(): string
    {
        return $this->scope;
    }

    public function state(): string
    {
        return $this->state;
    }
}
