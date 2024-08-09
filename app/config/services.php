<?php
/*
 * This file is part of the CoolStuff Enterprise Project.
 *
 * (c) Luyanda Siko <sikoluyanda@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use CoolStuff\Shared\Service\Invoice\InvoiceService;
use CoolStuff\Shared\Repository\UserRepositoryInterface;
use CoolStuff\Shared\Repository\InvoiceRepositoryInterface;
use CoolStuff\Customers\Domain\Repository\CustomerRepository;
use CoolStuff\Customers\Domain\Service\DefaultCustomerService;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

use function Symfony\Component\DependencyInjection\Loader\Configurator\service;

return static function (ContainerConfigurator $container): void {
    $services = $container->services();

    $services->set(DefaultCustomerService::class)
        ->arg('$customerRepository', service(CustomerRepository::class))
        ->public();

    $services->set(InvoiceService::class)
        ->arg('$invoices', service(InvoiceRepositoryInterface::class))
        ->arg('$users', service(UserRepositoryInterface::class));
};
