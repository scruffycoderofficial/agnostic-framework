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
use Psr\Log\LoggerInterface;
use Doctrine\DBAL\Connection;
use D6\Invoice\App\Auth\AuthService;
use D6\Invoice\App\Controller\AuthController;
use D6\Invoice\App\Repository\UserRepository;
use D6\Invoice\App\Repository\UserRepositoryInterface;

return static function (ContainerConfigurator $container): void {
    $services = $container->services();

    $services->set(UserRepository::class)
        ->arg('$connection', service(Connection::class));

    $services->alias(UserRepositoryInterface::class, UserRepository::class);

    $services->set(AuthService::class)
        ->arg('$users', service(UserRepositoryInterface::class));

    $services->set(AuthController::class)
        ->arg('$twig', service(Environment::class))
        ->arg('$authService', service(AuthService::class))
        ->arg('$logger', service(LoggerInterface::class))
        ->tag('controller.service_arguments')
        ->public();
};
