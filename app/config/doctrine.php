<?php
/*
 * This file is part of the D6 Assessment Project.
 *
 * (c) Luyanda Siko <sikoluyanda@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Doctrine\ORM\ORMSetup;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\DBAL\Tools\Console\ConnectionProvider;
use Doctrine\ORM\Tools\Console\Command\InfoCommand;
use Doctrine\ORM\Tools\Console\Command\RunDqlCommand;
use Doctrine\ORM\Tools\Console\EntityManagerProvider;
use Doctrine\DBAL\Tools\Console\Command\RunSqlCommand;
use Doctrine\DBAL\Tools\Console\Command\ReservedWordsCommand;
use Doctrine\ORM\Tools\Console\Command\ConvertMappingCommand;
use Doctrine\ORM\Tools\Console\Command\ValidateSchemaCommand;
use Doctrine\ORM\Tools\Console\Command\GenerateProxiesCommand;
use Doctrine\ORM\Tools\Console\Command\MappingDescribeCommand;
use Doctrine\ORM\Tools\Console\Command\SchemaTool\DropCommand;
use Doctrine\ORM\Tools\Console\Command\ClearCache\QueryCommand;
use Doctrine\ORM\Tools\Console\Command\GenerateEntitiesCommand;
use Doctrine\ORM\Tools\Console\Command\ClearCache\ResultCommand;
use Doctrine\ORM\Tools\Console\Command\SchemaTool\CreateCommand;
use Doctrine\ORM\Tools\Console\Command\SchemaTool\UpdateCommand;
use Doctrine\ORM\Tools\Console\Command\ClearCache\MetadataCommand;
use Doctrine\ORM\Tools\Console\Command\GenerateRepositoriesCommand;
use Doctrine\ORM\Tools\Console\Command\ClearCache\QueryRegionCommand;
use Doctrine\ORM\Tools\Console\Command\ClearCache\EntityRegionCommand;
use Doctrine\ORM\Tools\Console\Command\EnsureProductionSettingsCommand;
use Doctrine\ORM\Tools\Console\Command\ClearCache\CollectionRegionCommand;
use Doctrine\ORM\Tools\Console\EntityManagerProvider\SingleManagerProvider;
use Doctrine\DBAL\Tools\Console\ConnectionProvider\SingleConnectionProvider;

return static function (ContainerConfigurator $container): void {
    $services = $container->services();

    /*
     * Configure a Configuration instance
     */
    $services->set(Configuration::class)
        ->factory([ORMSetup::class, 'createAnnotationMetadataConfiguration'])
        ->args([
            [param('app.doctrine.orm.entity_paths')],
            param('app.debug'),
        ])
        ->public();

    /*
     * Configure an EntityManager instance
     */
    $services->set(EntityManager::class)
        ->args([
            service(Connection::class),
            service(Configuration::class),
        ])
        ->public();

    /*
     * Bind EntityManagerInterface into an EntityManager instance
     */
    $services->alias(EntityManagerInterface::class, EntityManager::class)
        ->public();

    /*
     * Configure a SingleConnectionProvider instance
     */
    $services->set(SingleConnectionProvider::class)
        ->arg('$connection', service(Connection::class))
        ->public();

    /*
     * Bind ConnectionProvider into a SingleConnectionProvider instance
     */
    $services->alias(ConnectionProvider::class, SingleConnectionProvider::class);

    /*
     * Configure DBAL Commands
     */
    $services->set(ReservedWordsCommand::class)
        ->arg('$connectionProvider', service(ConnectionProvider::class))
        ->tag('console.command')
        ->public();

    $services->set(RunSqlCommand::class)
        ->arg('$connectionProvider', service(ConnectionProvider::class))
        ->tag('console.command')
        ->public();

    /*
     * Configure a SingleManagerProvider instance
     */
    $services->set(SingleManagerProvider::class)
        ->arg('$entityManager', service(EntityManagerInterface::class))
        ->public();

    /*
     * Bind EntityManagerProvider into a SingleManagerProvider instance
     */
    $services->alias(EntityManagerProvider::class, SingleManagerProvider::class);

    /*
     * Configure ORM Commands
     */
    $services->set(CollectionRegionCommand::class)
        ->arg('$entityManagerProvider', service(EntityManagerProvider::class))
        ->tag('console.command')
        ->public();

    $services->set(EntityRegionCommand::class)
        ->arg('$entityManagerProvider', service(EntityManagerProvider::class))
        ->tag('console.command')
        ->public();

    $services->set(MetadataCommand::class)
        ->arg('$entityManagerProvider', service(EntityManagerProvider::class))
        ->tag('console.command')
        ->public();

    $services->set(QueryCommand::class)
        ->arg('$entityManagerProvider', service(EntityManagerProvider::class))
        ->tag('console.command')
        ->public();

    $services->set(QueryRegionCommand::class)
        ->arg('$entityManagerProvider', service(EntityManagerProvider::class))
        ->tag('console.command')
        ->public();

    $services->set(ResultCommand::class)
        ->arg('$entityManagerProvider', service(EntityManagerProvider::class))
        ->tag('console.command')
        ->public();

    $services->set(CreateCommand::class)
        ->arg('$entityManagerProvider', service(EntityManagerProvider::class))
        ->tag('console.command')
        ->public();

    $services->set(DropCommand::class)
        ->arg('$entityManagerProvider', service(EntityManagerProvider::class))
        ->tag('console.command')
        ->public();

    $services->set(UpdateCommand::class)
        ->arg('$entityManagerProvider', service(EntityManagerProvider::class))
        ->tag('console.command')
        ->public();

    $services->set(EnsureProductionSettingsCommand::class)
        ->arg('$entityManagerProvider', service(EntityManagerProvider::class))
        ->tag('console.command')
        ->public();

    $services->set(GenerateEntitiesCommand::class)
        ->arg('$entityManagerProvider', service(EntityManagerProvider::class))
        ->tag('console.command')
        ->public();

    $services->set(GenerateProxiesCommand::class)
        ->arg('$entityManagerProvider', service(EntityManagerProvider::class))
        ->tag('console.command')
        ->public();

    $services->set(GenerateRepositoriesCommand::class)
        ->arg('$entityManagerProvider', service(EntityManagerProvider::class))
        ->tag('console.command')
        ->public();

    $services->set(InfoCommand::class)
        ->arg('$entityManagerProvider', service(EntityManagerProvider::class))
        ->tag('console.command')
        ->public();

    $services->set(MappingDescribeCommand::class)
        ->arg('$entityManagerProvider', service(EntityManagerProvider::class))
        ->tag('console.command')
        ->public();

    $services->set(ConvertMappingCommand::class)
        ->arg('$entityManagerProvider', service(EntityManagerProvider::class))
        ->tag('console.command')
        ->public();

    $services->set(RunDqlCommand::class)
        ->arg('$entityManagerProvider', service(EntityManagerProvider::class))
        ->tag('console.command')
        ->public();

    $services->set(ValidateSchemaCommand::class)
        ->arg('$entityManagerProvider', service(EntityManagerProvider::class))
        ->tag('console.command')
        ->public();
};
