<?php

declare(strict_types=1);

namespace Crissanclick\App\Auth\Infrastructure\Symfony;

use Crissanclick\App\Auth\Domain\Exception\SubscriptionIsAlreadyPaid;
use Crissanclick\App\Auth\Domain\Subscription\BillingResponse;
use Crissanclick\App\Auth\Infrastructure\EnsureBilling;
use Shopify\Exception\CookieNotFoundException;
use Shopify\Exception\MissingArgumentException;
use Shopify\Utils;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\RequestEvent;

class EnsureShopifySession
{
    public function __construct(private readonly EnsureBilling $billing)
    {
    }

    /**
     * @throws CookieNotFoundException
     * @throws MissingArgumentException
     */
    public function onKernelRequest(RequestEvent $event): void
    {
        $shouldAuthenticate = $event->getRequest()->attributes->get('auth', false);
        if (!$shouldAuthenticate) {
            return;
        }

        $this->authenticate($event);
    }

    /**
     * @throws MissingArgumentException
     * @throws CookieNotFoundException
     */
    private function authenticate(RequestEvent $event): void
    {
        $request = $event->getRequest();
        $session = Utils::loadCurrentSession(
            $request->headers->all(),
            $request->cookies->all(),
            false
        );

        if (false === $session->isValid()) {
            return;
        }

        $isBillingRequired = (bool) $request->server->get('APP_BILLING_REQUIRED') ?? false;
        if (false === $isBillingRequired) {
            return;
        }

        try {
            $billing = $this->billing->check(
                $session,
                $this->getBillingConfiguration($request)
            );
        } catch (SubscriptionIsAlreadyPaid) {
            //silently ignore
            return;
        }

        if ($billing->confirmationUrl) {
            $this->redirectToConfirmationUrl($event, $billing);
        }
    }

    private function redirectToConfirmationUrl(RequestEvent $event, BillingResponse $billing): void
    {
        $request = $event->getRequest();
        $isBearerPresent = preg_match(
            "/Bearer (.*)/",
            $request->headers->get('Authorization', '')
        );
        $event->setResponse(
            $isBearerPresent !== false
                ? new JsonResponse('', 401, [
                'X-Shopify-API-Request-Failure-Reauthorize' => '1',
                'X-Shopify-API-Request-Failure-Reauthorize-Url' => $billing->confirmationUrl,
            ])
                : new RedirectResponse($billing->confirmationUrl)
        );
    }

    private function getBillingConfiguration(Request $request): array
    {
        return [
            'billing' => [
                'required' => (bool) $request->server->get('APP_BILLING_REQUIRED') ?? false,
                'chargeName' => $request->server->get('APP_BILLING_CHARGE_NAME') ?? '',
                'amount' => (int) $request->server->get('APP_BILLING_AMOUNT') ?? 0,
                'currencyCode' => $request->server->get('APP_BILLING_CURRENCY') ?? '',
                'interval' => $request->server->get('APP_BILLING_INTERVAL') ?? '',
                'type' => $request->server->get('APP_BILLING_TYPE') ?? '',
                'environment' => $request->server->get('APP_ENV') ?? ''
            ]
        ];
    }
}
