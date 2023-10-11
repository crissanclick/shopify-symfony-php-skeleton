<?php

declare(strict_types=1);

namespace Crissanclick\App\Shared\Infrastructure\Shopify;

use Crissanclick\App\Shared\Application\Session\CurrentSession;
use Shopify\Clients\Graphql;
use Shopify\Exception\HttpRequestException;
use Shopify\Exception\MissingArgumentException;

class ShopifyGraphQLClient
{
    public function __construct(private readonly CurrentSession $session)
    {
    }

    /**
     * @throws MissingArgumentException
     * @throws HttpRequestException
     */
    public function query(array|string $query): array
    {
        $response = $this->client()->query($query);

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * @throws MissingArgumentException
     */
    private function client(): Graphql
    {
        $session = $this->session->get();
        return new Graphql(
            $session->shop->value(),
            $session->accessToken->value()
        );
    }
}
