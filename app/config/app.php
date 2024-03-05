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
use Psr\Log\LoggerInterface;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManager;
use CoolStuff\App\Auth\AuthService;
use Psr\Container\ContainerInterface;
use CoolStuff\App\Service\InvoiceService;
use CoolStuff\App\Controller\AuthController;
use CoolStuff\App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormFactoryBuilder;
use Symfony\Component\HttpFoundation\Response;
use CoolStuff\App\Controller\ReportsController;
use CoolStuff\App\Repository\InvoiceRepository;
use CoolStuff\App\Controller\ProductsController;
use CoolStuff\Component\Service\PdfDocumentService;
use CoolStuff\App\Repository\UserRepositoryInterface;
use CoolStuff\App\Repository\InvoiceRepositoryInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use CoolStuff\App\Api\Controller\ProductsController as ApiProductsController;

return static function (ContainerConfigurator $container): void {
    $services = $container->services();

    $services->set(ContainerInterface::class, ContainerBuilder::class);

    $services->set(Request::class)
        ->factory([Request::class, 'createFromGlobals'])
        ->public();

    $services->set(Response::class)
        ->public();

    $services->set(UserRepository::class)
        ->arg('$connection', service(Connection::class));

    $services->alias(UserRepositoryInterface::class, UserRepository::class);

    $services->set(AuthService::class)
        ->arg('$users', service(UserRepositoryInterface::class))
        ->arg('$request', service(Request::class));

    $services->set(AuthController::class)
        ->arg('$twig', service(Environment::class))
        ->arg('$authService', service(AuthService::class))
        ->arg('$logger', service(LoggerInterface::class))
        ->tag('controller.service_arguments')
        ->public();

    $services->set(InvoiceRepository::class)
        ->arg('$connection', service(Connection::class));

    $services->alias(InvoiceRepositoryInterface::class, InvoiceRepository::class);

    $services->set(InvoiceService::class)
        ->arg('$invoices', service(InvoiceRepositoryInterface::class))
        ->arg('$users', service(UserRepositoryInterface::class));

    $services->set(ReportsController::class)
        ->arg('$authService', service(AuthService::class))
        ->arg('$invoiceService', service(InvoiceService::class))
        ->arg('$twig', service(Environment::class))
        ->arg('$forms', service(FormFactoryBuilder::class))
        ->arg('$pdfDocumentService', service(PdfDocumentService::class))
        ->arg('$userRepository', service(UserRepositoryInterface::class))
        ->arg('$entityManager', service(EntityManager::class))
        ->arg('$log', service(LoggerInterface::class))
        ->tag('controller.service_arguments')
        ->public();

    $services->set(ProductsController::class)
        ->arg('$twig', service(Environment::class))
        ->tag('controller.service_arguments')
        ->public();

    $services->set(ApiProductsController::class)
        ->arg('$entityManager', service(EntityManager::class))
        ->tag('controller.service_arguments')
        ->public();
};
