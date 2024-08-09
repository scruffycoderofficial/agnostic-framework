<?php
/*
 * This file is part of the CoolStuff Enterprise Project.
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
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\Tools\SchemaTool;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\ManagerRegistry;
use Doctrine\ORM\Mapping\Driver\AttributeDriver;
use Symfony\Component\Cache\Adapter\ArrayAdapter;
use Doctrine\DBAL\Tools\Console\ConnectionProvider;
use Doctrine\ORM\Tools\Console\Command\InfoCommand;
use Symfony\Bridge\Doctrine\Form\Type\DoctrineType;
use Doctrine\ORM\Tools\Console\Command\RunDqlCommand;
use Doctrine\ORM\Tools\Console\EntityManagerProvider;
use Doctrine\DBAL\Tools\Console\Command\RunSqlCommand;
use Doctrine\ORM\Tools\Console\Command\ValidateSchemaCommand;
use Doctrine\ORM\Tools\Console\Command\GenerateProxiesCommand;
use Doctrine\ORM\Tools\Console\Command\MappingDescribeCommand;
use Doctrine\ORM\Tools\Console\Command\SchemaTool\DropCommand;
use Doctrine\ORM\Tools\Console\Command\ClearCache\QueryCommand;
use Doctrine\ORM\Tools\Console\Command\ClearCache\ResultCommand;
use Doctrine\ORM\Tools\Console\Command\SchemaTool\CreateCommand;
use Doctrine\ORM\Tools\Console\Command\SchemaTool\UpdateCommand;
use Doctrine\ORM\Tools\Console\Command\ClearCache\MetadataCommand;
use Doctrine\ORM\Tools\Console\Command\ClearCache\QueryRegionCommand;
use Doctrine\ORM\Tools\Console\Command\ClearCache\EntityRegionCommand;
use Doctrine\ORM\Tools\Console\Command\ClearCache\CollectionRegionCommand;
use Doctrine\ORM\Tools\Console\EntityManagerProvider\SingleManagerProvider;
use Doctrine\DBAL\Tools\Console\ConnectionProvider\SingleConnectionProvider;

return static function (ContainerConfigurator $container): void {
    $services = $container->services();

    $services->set(DoctrineType::class)
        ->arg('$registry', service(ManagerRegistry::class));

    $services->set(ArrayAdapter::class);

    $services->set(AttributeDriver::class)
        ->args([
            param('app.doctrine.orm.entity_paths'),
            true,
        ]);

    $services->set(Configuration::class)
        ->factory([ORMSetup::class, 'createAttributeMetadataConfiguration'])
        ->args([
            param('app.doctrine.orm.entity_paths'),
            param('app.debug'),
        ])
        ->call('setMetadataCache', [service(ArrayAdapter::class)])
        ->call('setMetadataDriverImpl', [service(AttributeDriver::class)])
        ->call('setQueryCache', [service(ArrayAdapter::class)])
        ->call('setProxyDir', ['%app.doctrine.orm.entity_proxy_paths%'])
        ->call('setProxyNamespace', ['%app.doctrine.entity_proxy_namespace%'])
        ->call('setAutoGenerateProxyClasses', ['%app.debug%'])
        ->public();

    $services->set(Connection::class)
        ->factory([DriverManager::class, 'getConnection'])
        ->arg('$params', '%app.db.params%')
        ->arg('$config', service(Configuration::class));

    $services->set(EntityManager::class)
        ->args([
            service(Connection::class),
            service(Configuration::class),
        ])
        ->public();

    $services->alias(EntityManagerInterface::class, EntityManager::class)
        ->public();

    $services->set(SchemaTool::class)
        ->arg('$em', service(EntityManagerInterface::class));

    $services->set(SingleConnectionProvider::class)
        ->arg('$connection', service(Connection::class))
        ->public();

    $services->alias(ConnectionProvider::class, SingleConnectionProvider::class);

    $services->set(RunSqlCommand::class)
        ->arg('$connectionProvider', service(ConnectionProvider::class))
        ->tag('console.command')
        ->public();

    $services->set(SingleManagerProvider::class)
        ->arg('$entityManager', service(EntityManagerInterface::class))
        ->public();

    $services->alias(EntityManagerProvider::class, SingleManagerProvider::class);

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

    $services->set(GenerateProxiesCommand::class)
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

    $services->set(RunDqlCommand::class)
        ->arg('$entityManagerProvider', service(EntityManagerProvider::class))
        ->tag('console.command')
        ->public();

    $services->set(ValidateSchemaCommand::class)
        ->arg('$entityManagerProvider', service(EntityManagerProvider::class))
        ->tag('console.command')
        ->public();
};
