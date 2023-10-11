<?php

declare(strict_types=1);

namespace Crissanclick\App\Shared\Infrastructure\Shopify\Persistence;

use Crissanclick\App\Shared\Infrastructure\Shopify\ShopifyGraphQLClient;

abstract class ShopifyAbstractGraphQLRepository
{
    public function __construct(
        public readonly ShopifyGraphQLClient $client
    ) {
    }
}
