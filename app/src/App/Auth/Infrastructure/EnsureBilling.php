<?php

declare(strict_types=1);

namespace Crissanclick\App\Auth\Infrastructure;

use Crissanclick\App\Auth\Domain\Subscription\Billing;
use Crissanclick\App\Auth\Domain\Subscription\BillingResponse;
use Shopify\Auth\Session;
use Shopify\Context;

class EnsureBilling
{
    public function __construct(
        private readonly iterable $billings
    ) {
    }

    public function check(Session $session, array $config): BillingResponse
    {
        $confirmationUrl = null;
        $returnUrl = $this->returnUrl($session->getShop());
        /** @var Billing $billing */
        foreach ($this->billings as $billing) {
            $confirmationUrl = $billing->requestPayment(
                strtolower($config['billing']['type'] ?? ''),
                $config['billing']['chargeName'] ?? '',
                $returnUrl,
                $config['billing']['amount'] ?? 0,
                $config['billing']['currencyCode'] ?? '',
                $config['billing']['environment'] ?? 'production'
            );

            if (null !== $confirmationUrl) {
                return new BillingResponse($confirmationUrl);
            }
        }

        return new BillingResponse($confirmationUrl ?? '');
    }

    private function returnUrl(string $shop): string
    {
        $hostName = Context::$HOST_NAME;
        $host = base64_encode("$shop/admin");
        return "https://$hostName?shop={$shop}&host=$host";
    }
}
