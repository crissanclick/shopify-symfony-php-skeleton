<?php

declare(strict_types=1);

namespace Crissanclick\App\Shared\Domain;

class Session
{
    public function __construct(
        public readonly ShopId $shop,
        public readonly AccessToken $accessToken,
    ) {
    }
}
