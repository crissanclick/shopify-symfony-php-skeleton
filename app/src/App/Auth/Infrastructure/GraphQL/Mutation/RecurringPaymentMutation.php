<?php

declare(strict_types=1);

namespace Crissanclick\App\Auth\Infrastructure\GraphQL\Mutation;

use Crissanclick\App\Shared\Domain\Request\Mutation;

class RecurringPaymentMutation implements Mutation
{
    public function mutation(): string
    {
        return <<<'QUERY'
            mutation createPaymentMutation(
                $name: String!
                $lineItems: [AppSubscriptionLineItemInput!]!
                $returnUrl: URL!
                $test: Boolean
            ) {
                appSubscriptionCreate(
                    name: $name
                    lineItems: $lineItems
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
