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

use Monolog\Logger;
use Psr\Log\LoggerInterface;
use Monolog\Handler\StreamHandler;

/**
 * @see https://stackify.com/php-monolog-tutorial/
 */
return static function (ContainerConfigurator $container): void {
    $services = $container->services();

    $services->set(StreamHandler::class)
        ->arg('$stream', __DIR__.'/../var/log/debug.log')
        ->public();

    $services->set(Logger::class)
        ->arg('$name', 'daily')
        ->call('pushHandler', [service(StreamHandler::class)])
        ->public();

    $services->alias(LoggerInterface::class, service(Logger::class))
        ->public();
};
