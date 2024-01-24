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

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;

return static function (ContainerConfigurator $container): void {
    $services = $container->services();

    $services->set(Connection::class)
        ->factory([DriverManager::class, 'getConnection'])
        ->arg('$params', '%db.params%');
};
