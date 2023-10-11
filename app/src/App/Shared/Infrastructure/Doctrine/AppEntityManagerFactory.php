<?php

declare(strict_types=1);

namespace Crissanclick\App\Shared\Infrastructure\Doctrine;

use Crissanclick\Shared\Infrastructure\Doctrine\DbalTypesSearcher;
use Crissanclick\Shared\Infrastructure\Doctrine\DoctrineEntityManagerFactory;
use Crissanclick\Shared\Infrastructure\Doctrine\DoctrinePrefixesSearcher;
use Doctrine\ORM\EntityManagerInterface;

final class AppEntityManagerFactory
{
    private const SCHEMA_PATH = __DIR__ . '/../../../../../etc/databases/skeleton-app.sql';

    public static function create(array $parameters, string $environment): EntityManagerInterface
    {
        $isDevMode = 'prod' !== $environment;

        $prefixes = array_merge(
            DoctrinePrefixesSearcher::inPath(
                __DIR__ . '/../../../../App',
                'Crissanclick\App'
            )
        );

        $dbalCustomTypesClasses = DbalTypesSearcher::inPath(
            __DIR__ . '/../../../../App',
            'Crissanclick\App'
        );

        return DoctrineEntityManagerFactory::create(
            $parameters,
            $prefixes,
            $isDevMode,
            self::SCHEMA_PATH,
            $dbalCustomTypesClasses
        );
    }
}
