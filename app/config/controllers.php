<?php
/*
 * This file is part of the CoolStuff Enterprise Project.
 *
 * (c) Luyanda Siko <sikoluyanda@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use Twig\Environment;
use Psr\Log\LoggerInterface;
use Doctrine\ORM\EntityManager;
use CoolStuff\App\Controller\AuthController;
use Symfony\Component\Form\FormFactoryBuilder;
use CoolStuff\App\Controller\ReportsController;
use CoolStuff\App\Controller\JournalsController;
use CoolStuff\App\Controller\ProductsController;
use CoolStuff\Shared\Service\Invoice\InvoiceService;
use Symfony\Component\Routing\Generator\UrlGenerator;
use CoolStuff\Component\Controller\AbstractController;
use CoolStuff\App\Admin\Controller\DashboardController;
use CoolStuff\App\Service\Product\OnlineProductsSyncer;
use CoolStuff\Shared\Repository\UserRepositoryInterface;
use CoolStuff\Shared\Repository\ProductRepositoryInterface;
use CoolStuff\Component\Service\DocumentWriter\PdfDocumentWriter;
use CoolStuff\Api\Controller\ProductsController as ApiProductsController;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

use function Symfony\Component\DependencyInjection\Loader\Configurator\service;

return static function (ContainerConfigurator $container): void {
    $services = $container->services();

    $services->set(AbstractController::class)
        ->args([service(UrlGenerator::class)])
        ->call('setContainer', [service('service_container')])
        ->abstract(true);

    $services->set(AuthController::class)
        ->arg('$twig', service(Environment::class))
        ->arg('$logger', service(LoggerInterface::class))
        ->tag('controller.service_arguments')
        ->public();

    $services->set(ProductsController::class)
        ->arg('$productRepository', service(ProductRepositoryInterface::class))
        ->arg('$productsSyncer', service(OnlineProductsSyncer::class))
        ->parent(AbstractController::class)
        ->tag('controller.service_arguments')
        ->public();

    $services->set(JournalsController::class)
        ->arg('$productRepository', service(ProductRepositoryInterface::class))
        ->parent(AbstractController::class)
        ->tag('controller.service_arguments')
        ->public();

    $services->set(ReportsController::class)
        ->arg('$invoiceService', service(InvoiceService::class))
        ->arg('$twig', service(Environment::class))
        ->arg('$forms', service(FormFactoryBuilder::class))
        ->arg('$pdfDocumentService', service(PdfDocumentWriter::class))
        ->arg('$userRepository', service(UserRepositoryInterface::class))
        ->arg('$entityManager', service(EntityManager::class))
        ->arg('$log', service(LoggerInterface::class))
        ->tag('controller.service_arguments')
        ->public();

    $services->set(ApiProductsController::class)
        ->arg('$productRepository', service(ProductRepositoryInterface::class))
        ->tag('controller.service_arguments')
        ->public();

    /**$services->set(DashboardController::class)
        ->parent(AbstractController::class)
        ->tag('controller.service_arguments')
        ->public();*/
};
