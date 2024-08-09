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

use Doctrine\DBAL\Connection;
use Doctrine\Migrations\DependencyFactory;
use Doctrine\Migrations\Tools\Console\Command;
use Doctrine\Migrations\Configuration\Configuration;
use Doctrine\Migrations\Configuration\Connection\ExistingConnection;
use Doctrine\Migrations\Configuration\Migration\ExistingConfiguration;
use Doctrine\Migrations\Metadata\Storage\TableMetadataStorageConfiguration;

return static function (ContainerConfigurator $container): void {
    $services = $container->services();

    $services->set(TableMetadataStorageConfiguration::class)
        ->call('setTableName', ['migrations'])
        ->public();

    $services->set(Configuration::class)
        ->call('addMigrationsDirectory', [
            'CoolStuff\Database\Migrations',
            __DIR__.'/../db/migrations',
            __DIR__ . '/../src/Shared/Workflow/Domain/Migrations'
        ])
        ->call('setAllOrNothing', [true])
        ->call('setCheckDatabasePlatform', [false])
        ->call('setMetadataStorageConfiguration', [service(TableMetadataStorageConfiguration::class)])
        ->public();

    $services->set(ExistingConnection::class)
        ->arg('$connection', service(Connection::class))
        ->public();

    $services->set(ExistingConfiguration::class)
        ->arg('$configurations', service(Configuration::class))
        ->public();

    $services->set(DependencyFactory::class)
        ->factory([DependencyFactory::class, 'fromConnection'])
        ->args([
            service(ExistingConfiguration::class),
            service(ExistingConnection::class),
        ]);

    $services->set(Command\CurrentCommand::class)
        ->arg('$dependencyFactory', service(DependencyFactory::class))
        ->tag('console.command')
        ->public();

    $services->set(Command\CurrentCommand::class)
        ->arg('$dependencyFactory', service(DependencyFactory::class))
        ->tag('console.command')
        ->public();

    $services->set(Command\DumpSchemaCommand::class)
        ->arg('$dependencyFactory', service(DependencyFactory::class))
        ->tag('console.command')
        ->public();

    $services->set(Command\ExecuteCommand::class)
        ->arg('$dependencyFactory', service(DependencyFactory::class))
        ->tag('console.command')
        ->public();

    $services->set(Command\GenerateCommand::class)
        ->arg('$dependencyFactory', service(DependencyFactory::class))
        ->tag('console.command')
        ->public();

    $services->set(Command\LatestCommand::class)
        ->arg('$dependencyFactory', service(DependencyFactory::class))
        ->tag('console.command')
        ->public();

    $services->set(Command\ListCommand::class)
        ->arg('$dependencyFactory', service(DependencyFactory::class))
        ->tag('console.command')
        ->public();

    $services->set(Command\MigrateCommand::class)
        ->arg('$dependencyFactory', service(DependencyFactory::class))
        ->tag('console.command')
        ->public();

    $services->set(Command\RollupCommand::class)
        ->arg('$dependencyFactory', service(DependencyFactory::class))
        ->tag('console.command')
        ->public();

    $services->set(Command\StatusCommand::class)
        ->arg('$dependencyFactory', service(DependencyFactory::class))
        ->tag('console.command')
        ->public();

    $services->set(Command\SyncMetadataCommand::class)
        ->arg('$dependencyFactory', service(DependencyFactory::class))
        ->tag('console.command')
        ->public();

    $services->set(Command\UpToDateCommand::class)
        ->arg('$dependencyFactory', service(DependencyFactory::class))
        ->tag('console.command')
        ->public();

    $services->set(Command\VersionCommand::class)
        ->arg('$dependencyFactory', service(DependencyFactory::class))
        ->tag('console.command')
        ->public();
};
