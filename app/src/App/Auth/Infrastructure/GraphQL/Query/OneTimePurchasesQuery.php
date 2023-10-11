<?php

declare(strict_types=1);

namespace Crissanclick\App\Auth\Infrastructure\GraphQL\Query;

use Crissanclick\App\Shared\Domain\Request\Query;

class OneTimePurchasesQuery implements Query
{
    public function get(): string
    {
        return <<<'QUERY'
            query appPurchases($endCursor: String) {
                currentAppInstallation {
                    oneTimePurchases(first: 250, sortKey: CREATED_AT, after: $endCursor) {
                        edges {
                            node {
                                name, test, status
                            }
                        }
                        pageInfo {
                            hasNextPage, endCursor
                        }
                    }
                }
            }
        QUERY;
    }
}
