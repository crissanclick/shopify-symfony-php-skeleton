<?php

declare(strict_types=1);

namespace Crissanclick\App\Auth\Infrastructure\GraphQL\Mutation;

use Crissanclick\App\Shared\Domain\Request\Mutation;

class OneTimePaymentMutation implements Mutation
{
    public function mutation(): string
    {
        return <<<'QUERY'
            mutation createPaymentMutation(
                $name: String!
                $price: MoneyInput!
                $returnUrl: URL!
                $test: Boolean
            ) {
                appPurchaseOneTimeCreate(
                    name: $name
                    price: $price
                    returnUrl: $returnUrl
                    test: $test
                ) {
                    confirmationUrl
                    userErrors {
                        field, message
                    }
                }
            }
        QUERY;
    }
}
