<?php

declare(strict_types=1);

namespace Crissanclick\App\Auth\Infrastructure\Cookie;

use Shopify\Auth\OAuthCookie;
use Shopify\Context;

class CookieHandler
{
    public function save(OAuthCookie $cookie): bool
    {
        $cookieValues = [
            'expires' => $cookie->getExpire(),
            'path' => '/',
            'domain' => Context::$HOST_NAME,
            'secure' => $cookie->isSecure(),
            'httponly' => $cookie->isHttpOnly(),
            'samesite' => 'None'
        ];
        setcookie($cookie->getName(), $cookie->getValue(), $cookieValues);

        return true;
    }
}
