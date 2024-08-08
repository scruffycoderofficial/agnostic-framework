<?php
/*
 * This file is part of the CoolStuff Enterprise Project.
 *
 * (c) Luyanda Siko <sikoluyanda@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use Doctrine\ORM\EntityManagerInterface;
use CoolStuff\Shared\Repository\UserRepository;
use CoolStuff\Shared\Repository\InvoiceRepository;
use CoolStuff\Shared\Repository\ProductRepository;
use CoolStuff\Shared\Repository\UserRepositoryInterface;
use CoolStuff\Shared\Repository\InvoiceRepositoryInterface;
use CoolStuff\Shared\Repository\ProductRepositoryInterface;
use CoolStuff\Customers\Persistence\Doctrine\Repository\CustomerRepository;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use CoolStuff\Customers\Domain\Repository\CustomerRepository as CustomerRepositoryInterface;

use function Symfony\Component\DependencyInjection\Loader\Configurator\service;

return static function (ContainerConfigurator $container): void {
    $services = $container->services();

    $services->set(CustomerRepository::class)
        ->arg('$em', service(EntityManagerInterface::class))
        ->alias(CustomerRepositoryInterface::class, CustomerRepository::class)
        ->public();

    $services->set(UserRepository::class)
        ->alias(UserRepositoryInterface::class, UserRepository::class);

    $services->set(InvoiceRepository::class)
        ->alias(InvoiceRepositoryInterface::class, InvoiceRepository::class);

    $services->set(ProductRepository::class)
        ->arg('$manager', service(EntityManagerInterface::class))
        ->alias(ProductRepositoryInterface::class, ProductRepository::class);
};
