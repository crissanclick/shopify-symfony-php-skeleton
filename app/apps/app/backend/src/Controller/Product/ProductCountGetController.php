<?php

declare(strict_types=1);

namespace Crissanclick\Apps\App\Backend\Controller\Product;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ProductCountGetController
{
    public function __invoke(Request $request): JsonResponse
    {
        return new JsonResponse(['count' => 10]);
    }
}
