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

use D6\Invoice\Component\Orm\ConnectionProvider;
use D6\Invoice\Component\Orm\ConnectionProviderFactory;
use D6\Invoice\Component\Orm\ConnectionProviderFactoryInterface;

return static function (ContainerConfigurator $container): void {
    $services = $container->services();

    $services->set(ConnectionProviderFactory::class);

    $services->alias(ConnectionProviderFactoryInterface::class, ConnectionProviderFactory::class);

    $services->set(ConnectionProvider::class)
        ->factory([service(ConnectionProviderFactory::class), 'createConnector'])
        ->args([
            getenv('DB_DSN'),
            getenv('DB_USERNAME'),
            getenv('DB_PASSWORD'),
        ]);
};
