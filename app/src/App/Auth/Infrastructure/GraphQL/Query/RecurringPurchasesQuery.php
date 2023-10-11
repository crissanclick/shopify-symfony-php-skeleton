<?php

declare(strict_types=1);

namespace Crissanclick\App\Auth\Infrastructure\GraphQL\Query;

use Crissanclick\App\Shared\Domain\Request\Query;

class RecurringPurchasesQuery implements Query
{
    public function get(): string
    {
        return <<<'QUERY'
            query appSubscription {
                currentAppInstallation {
                    activeSubscriptions {
                        name, test
                    }
                }
            }
        QUERY;
    }
}
