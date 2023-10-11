<?php

declare(strict_types=1);

namespace Crissanclick\App\Shared\Application\Session;

use Crissanclick\App\Shared\Domain\AccessToken;
use Crissanclick\App\Shared\Domain\Session;
use Crissanclick\App\Shared\Domain\ShopId;

class CurrentSession
{
    private ?Session $session = null;

    public function register(string $shop, string $token): void
    {
        $this->session = new Session(
            new ShopId($shop),
            new AccessToken($token)
        );
    }

    public function get(): ?Session
    {
        return $this->session;
    }
}
