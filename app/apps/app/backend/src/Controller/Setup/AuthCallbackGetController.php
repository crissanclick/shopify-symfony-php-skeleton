<?php

declare(strict_types=1);

namespace Crissanclick\Apps\App\Backend\Controller\Setup;

use Shopify\Auth\OAuth;
use Shopify\Exception\HttpRequestException;
use Shopify\Exception\InvalidArgumentException;
use Shopify\Exception\InvalidOAuthException;
use Shopify\Exception\OAuthCookieNotFoundException;
use Shopify\Exception\OAuthSessionNotFoundException;
use Shopify\Exception\PrivateAppException;
use Shopify\Exception\SessionStorageException;
use Shopify\Exception\UninitializedContextException;
use Shopify\Utils;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class AuthCallbackGetController
{
    /**
     * @param Request $request
     * @return RedirectResponse
     * @throws HttpRequestException
     * @throws InvalidArgumentException
     * @throws InvalidOAuthException
     * @throws OAuthCookieNotFoundException
     * @throws OAuthSessionNotFoundException
     * @throws PrivateAppException
     * @throws SessionStorageException
     * @throws UninitializedContextException
     */
    public function __invoke(Request $request): RedirectResponse
    {
        OAuth::callback(
            $request->cookies->all(),
            $request->query->all()
        );
        $host = $request->get('host');
        $redirectUrl = Utils::getEmbeddedAppUrl($host);
        return new RedirectResponse($redirectUrl);
    }
}
