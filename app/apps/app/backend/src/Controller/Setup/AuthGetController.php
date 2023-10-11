<?php

declare(strict_types=1);

namespace Crissanclick\Apps\App\Backend\Controller\Setup;

use Crissanclick\App\Auth\Infrastructure\Authentication;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthGetController
{
    public function __construct(
        private readonly Authentication $authenticator
    ) {
    }

    /**
     * @throws Exception
     */
    public function __invoke(Request $request): Response
    {
        return $this->authenticator->redirect($request);
    }
}
