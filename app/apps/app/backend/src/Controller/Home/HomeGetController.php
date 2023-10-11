<?php

declare(strict_types=1);

namespace Crissanclick\Apps\App\Backend\Controller\Home;

use Crissanclick\Shared\Infrastructure\Symfony\WebController;
use Symfony\Component\HttpFoundation\Response;

class HomeGetController extends WebController
{
    public function __invoke(): Response
    {
        return $this->render(
            'index.html.twig'
        );
    }

    protected function exceptions(): array
    {
        return [];
    }
}
