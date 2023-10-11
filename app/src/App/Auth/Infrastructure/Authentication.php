<?php

declare(strict_types=1);

namespace Crissanclick\App\Auth\Infrastructure;

use Crissanclick\App\Auth\Infrastructure\Cookie\CookieHandler;
use Shopify\Auth\OAuth;
use Shopify\Context;
use Shopify\Exception\CookieSetException;
use Shopify\Exception\PrivateAppException;
use Shopify\Exception\SessionStorageException;
use Shopify\Exception\UninitializedContextException;
use Shopify\Utils;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class Authentication
{
    /**
     * @throws CookieSetException
     * @throws UninitializedContextException
     * @throws PrivateAppException
     * @throws SessionStorageException
     */
    public function redirect(Request $request): RedirectResponse
    {
        $shop = Utils::sanitizeShopDomain($request->get('shop'));
        if (Context::$IS_EMBEDDED_APP && $request->get('embedded', false) === '1') {
            return new RedirectResponse(
                $this->clientRedirect($shop, $request->query->all())
            );
        }
        return new RedirectResponse($this->serverRedirect($shop));
    }

    private function clientRedirect(string $shop, array $query): string
    {
        $appHost = Context::$HOST_NAME;
        $redirectUri = urlencode("https://$appHost/api/auth?shop=$shop");

        $queryString = http_build_query(array_merge($query, ["redirectUri" => $redirectUri]));
        return "./ExitIframe?$queryString";
    }

    /**
     * @throws CookieSetException
     * @throws UninitializedContextException
     * @throws PrivateAppException
     * @throws SessionStorageException
     */
    private function serverRedirect(string $shop): string
    {
        return OAuth::begin(
            $shop,
            '/api/auth/callback',
            false,
            [new CookieHandler(), 'save']
        );
    }
}
