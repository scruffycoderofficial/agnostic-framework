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

use Twig\Environment;
use Doctrine\DBAL\Connection;
use D6\Invoice\Component\Console\Application;
use Symfony\Bridge\Twig\Command\DebugCommand;
use Symfony\Component\Console\Command\Command;
use D6\Invoice\App\Console\Command\ListUsersCommand;
use Symfony\Component\Translation\Command\XliffLintCommand;
use Symfony\Bridge\Twig\Command\LintCommand as TwigLintCommand;
use Symfony\Component\Yaml\Command\LintCommand as YamlLintCommand;

return static function (ContainerConfigurator $container): void {
    $services = $container->services();

    $services->set(ListUsersCommand::class)
        ->arg('$connection', service(Connection::class))
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

    $services->set(Application::class)
        ->args([tagged_iterator('console.command')])
        ->call('setCatchExceptions', [true])
        ->public();
};
