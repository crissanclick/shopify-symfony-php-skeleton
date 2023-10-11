<?php

declare(strict_types=1);

namespace Crissanclick\App\Auth\Infrastructure\GraphQL;

use Crissanclick\App\Auth\Domain\Subscription\Persistence\SubscriptionRepository;
use Crissanclick\App\Auth\Domain\Subscription\Subscription;
use Crissanclick\App\Auth\Infrastructure\GraphQL\Mutation\OneTimePaymentMutation;
use Crissanclick\App\Auth\Infrastructure\GraphQL\Mutation\RecurringPaymentMutation;
use Crissanclick\App\Auth\Infrastructure\GraphQL\Query\ActiveSubscriptionQuery;
use Crissanclick\App\Auth\Infrastructure\GraphQL\Query\OneTimePurchasesQuery;
use Crissanclick\App\Auth\Infrastructure\GraphQL\Query\RecurringPurchasesQuery;
use Crissanclick\App\Shared\Infrastructure\Shopify\Persistence\ShopifyAbstractGraphQLRepository;
use Shopify\Exception\HttpRequestException;
use Shopify\Exception\MissingArgumentException;

class GraphQLSubscriptionRepository extends ShopifyAbstractGraphQLRepository implements SubscriptionRepository
{
    /**
     * @throws HttpRequestException
     * @throws MissingArgumentException
     */
    public function listActiveSubscriptions(): Subscription
    {
        $query = new ActiveSubscriptionQuery();
        $this->client->query($query->get());

        return new Subscription('a');
    }

    /**
     * @throws MissingArgumentException
     * @throws HttpRequestException
     */
    public function oneTimePurchases(array $parameters): array
    {
        $query = new OneTimePurchasesQuery();
        return $this->client->query(
            [
                'query' => $query->get(),
                'variables' => $parameters,
            ]
        );
    }

    /**
     * @throws MissingArgumentException
     * @throws HttpRequestException
     */
    public function recurringPurchases(): array
    {
        $query = new RecurringPurchasesQuery();
        return $this->client->query($query->get());
    }

    /**
     * @throws MissingArgumentException
     * @throws HttpRequestException
     */
    public function payRecurring(
        string $chargeName,
        string $interval,
        float $amount,
        string $currency,
        string $returnUrl,
        string $environment
    ): string {
        $mutation = new RecurringPaymentMutation();
        return $this->client->query(
            [
                'query' => $mutation->mutation(),
                'variables' => [
                    'name' => $chargeName,
                    'lineItems' => [
                        [
                            'plan' => [
                                'appRecurringPricingDetails' => [
                                    'interval' => $interval,
                                    'price' => [
                                        'amount' => $amount,
                                        'currencyCode' => $currency,
                                    ],
                                ],
                            ],
                        ],
                    ],
                    'returnUrl' => $returnUrl,
                    'test' => ($environment === 'development'),
                ],
            ]
        )['data']['appSubscriptionCreate']['confirmationUrl'] ?? '';
    }

    /**
     * @throws MissingArgumentException
     * @throws HttpRequestException
     */
    public function payOneTime(
        string $name,
        float $amount,
        string $returnUrl,
        string $currency,
        string $environment
    ): string {
        $mutation = new OneTimePaymentMutation();
        return $this->client->query(
            [
                'query' => $mutation->mutation(),
                'variables' => [
                    'name' => $name,
                    'price' => [
                        'amount' => $amount,
                        'currencyCode' => $currency,
                    ],
                    'returnUrl' => $returnUrl,
                    'test' => ($environment === 'development'),
                ],
            ]
        )['data']['appPurchaseOneTimeCreate']['confirmationUrl'] ?? '';
    }
}
