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

use Twig\Environment;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManager;
use Doctrine\Common\DataFixtures\Loader;
use CoolStuff\Component\Console\Application;
use Symfony\Bridge\Twig\Command\DebugCommand;
use Symfony\Component\Console\Command\Command;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Symfony\Component\DependencyInjection\Reference;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use CoolStuff\App\Service\Product\OnlineProductsSyncer;
use CoolStuff\App\Console\Command\User\ListUsersCommand;
use CoolStuff\Shared\Repository\ProductRepositoryInterface;
use Symfony\Component\Translation\Command\XliffLintCommand;
use CoolStuff\Component\Console\Command\ListFixturesCommand;
use CoolStuff\App\Console\Command\Product\ListProductsCommand;
use CoolStuff\Component\Console\Command\ExecuteFixturesCommand;
use Symfony\Bridge\Twig\Command\LintCommand as TwigLintCommand;
use CoolStuff\App\Console\Command\Product\CreateProductsCommand;
use Symfony\Component\Yaml\Command\LintCommand as YamlLintCommand;

return static function (ContainerConfigurator $container): void {
    $services = $container->services();

    $services->set(ListUsersCommand::class)
        ->arg('$connection', service(Connection::class))
        ->tag('console.command');

    $services->set(ListProductsCommand::class)
        ->arg('$productRepository', service(ProductRepositoryInterface::class))
        ->tag('console.command');

    $services->set(CreateProductsCommand::class)
        ->arg('$onlineProductsSyncer', service(OnlineProductsSyncer::class))
        ->tag('console.command');

    $services->set(ListFixturesCommand::class)
        ->arg('$loader', new Reference(Loader::class))
        ->arg('$path', '%app.doctrine.fixtures_path%')
        ->tag('console.command');

    $services->set(ListFixturesCommand::class)
        ->arg('$loader', new Reference(Loader::class))
        ->arg('$path', '%app.doctrine.fixtures_path%')
        ->tag('console.command');

    $services->set(ExecuteFixturesCommand::class)
        ->arg('$entityManager', new Reference(EntityManager::class))
        ->arg('$loader', new Reference(Loader::class))
        ->arg('$purger', new Reference(ORMPurger::class))
        ->arg('$executor', new Reference(ORMExecutor::class))
        ->arg('$path', '%app.doctrine.fixtures_path%')
        ->tag('console.command');

    $services->set(YamlLintCommand::class)
        ->tag('console.command');

    $services->set(TwigLintCommand::class)
        ->arg('$twig', service(Environment::class))
        ->tag('console.command');

    $services->set(DebugCommand::class)
        ->arg('$twig', service(Environment::class))
        ->tag('console.command');

    $services->set(XliffLintCommand::class)
        ->tag('console.command');

    $services->instanceof(Command::class)
        ->tag('console.command');

    $services->set('coolstuff.console.app', Application::class)
        ->arg('$commands', tagged_iterator('console.command'))
        ->call('setCatchExceptions', [true])
        ->public();
};
