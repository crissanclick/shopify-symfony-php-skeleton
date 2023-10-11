<?php

declare(strict_types=1);

namespace Crissanclick\App\Auth\Infrastructure\Symfony;

use Crissanclick\App\Auth\Application\Session\Find\SessionRegistered;
use Crissanclick\App\Auth\Infrastructure\Authentication;
use Exception;
use Symfony\Component\HttpKernel\Event\RequestEvent;

class EnsureAppInstalled
{
    public function __construct(
        private readonly SessionRegistered $sessionRegistered,
        private readonly Authentication $authentication
    ) {
    }

    /**
     * @throws Exception
     */
    public function onKernelRequest(RequestEvent $event): void
    {
        $shouldAuthenticate = $event->getRequest()->attributes->get('check_installation', true);
        if (!$shouldAuthenticate) {
            return;
        }

        $shop = $event->getRequest()->get('shop');
        if (null === $shop) {
            return;
        }

        $isExitingIframe = str_contains('ExitIframe', $event->getRequest()->getPathInfo());
        $isShopAlreadyRegistered = $this->sessionRegistered->has($shop);
        if (false === $isShopAlreadyRegistered || true === $isExitingIframe) {
            $event->setResponse(
                $this->authentication->redirect($event->getRequest())
            );
        }
    }
}
