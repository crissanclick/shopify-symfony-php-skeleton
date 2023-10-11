<?php

declare(strict_types = 1);

namespace Crissanclick\Apps\App\Backend\Controller\HealthCheck;

use Crissanclick\Shared\Domain\RandomNumberGenerator;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class HealthCheckGetController
{
    public function __construct(private readonly RandomNumberGenerator $generator)
    {
    }

    public function __invoke(Request $request): Response
    {
        return new JsonResponse(
            [
                'app-skeleton' => 'ok',
                'rand'         => $this->generator->generate(),
            ]
        );
    }
}
