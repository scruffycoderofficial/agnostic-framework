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
use Psr\Container\ContainerInterface;
use D6\Invoice\App\Service\InvoiceService;
use D6\Invoice\App\Controller\AuthController;
use D6\Invoice\App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormFactoryBuilder;
use D6\Invoice\App\Controller\ReportsController;
use D6\Invoice\App\Repository\InvoiceRepository;
use D6\Invoice\Component\Service\PdfDocumentService;
use Symfony\Component\DependencyInjection\Container;
use D6\Invoice\App\Repository\UserRepositoryInterface;
use D6\Invoice\App\Repository\InvoiceRepositoryInterface;

return static function (ContainerConfigurator $container): void {
    $services = $container->services();

    $services->set(ContainerInterface::class, Container::class);

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
        ->arg('$log', service(LoggerInterface::class))
        ->tag('controller.service_arguments')
        ->public();
};
