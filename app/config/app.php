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

use Psr\Container\ContainerInterface;
use D6\Invoice\Component\Console\Command\ListUsersCommand;
use Symfony\Component\DependencyInjection\ContainerBuilder;

return static function (ContainerConfigurator $container): void {
    $services = $container->services();

    $services->set(ContainerInterface::class, ContainerBuilder::class);

    $services->set(ListUsersCommand::class)
        ->tag('console.command')
        ->public();
};
