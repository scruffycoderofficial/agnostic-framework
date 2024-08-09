<?php
/*
 * This file is part of the CoolStuff Enterprise Project.
 *
 * (c) Luyanda Siko <sikoluyanda@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use CoolStuff\App;
use Symfony\Component\Routing;

$routes = new Routing\RouteCollection();

$routes->add('admin_dashboard', new Routing\Route('/admin/dashboard', [
    '_controller' => [App\Admin\Controller\DashboardController::class, 'indexAction'],
]));

/**
 * Auth Routes.
 */
(function (Routing\RouteCollection $routes) {
    $routes->add('login', new Routing\Route('/login', [
        '_controller' => [App\Controller\AuthController::class, 'loginAction'],
    ]));

    $routes->add('logout', new Routing\Route('/logout', [
        '_controller' => [App\Controller\AuthController::class, 'logoutAction'],
    ]));
})($routes);

/**
 * Products API Routes.
 */
(function (Routing\RouteCollection $routes) {
    $routes->add('api_products_create', new Routing\Route('/v1/api/products/create', [
        '_controller' => [CoolStuff\Api\Controller\ProductsController::class, 'createAction'],
    ]));

    $routes->add('api_products_list', new Routing\Route('/v1/api/products', [
        '_controller' => [CoolStuff\Api\Controller\ProductsController::class, 'listAction'],
    ]));
})($routes);

/**
 * Products Admin Routes.
 */
(function (Routing\RouteCollection $routes) {
    $routes->add('admin_products_list', new Routing\Route('/admin/products', [
        '_controller' => [App\Controller\ProductsController::class, 'listAction'],
    ]));

    $routes->add('admin_products_create', new Routing\Route('/admin/products/create', [
        '_controller' => [App\Controller\ProductsController::class, 'createAction'],
    ]));

    $routes->add('admin_products_update', new Routing\Route('/admin/products/{productId}/update', [
        '_controller' => [App\Controller\ProductsController::class, 'updateAction'],
    ]));

    $routes->add('admin_products_view', new Routing\Route('/admin/products/{productId}/view', [
        '_controller' => [App\Controller\ProductsController::class, 'viewAction'],
        'method' => 'GET|POST',
    ]));

    $routes->add('admin_products_create_stock_journal', new Routing\Route('admin/journals/product/{productId}/create', [
        '_controller' => [App\Controller\JournalsController::class, 'createJournalAction'],
    ]));
})($routes);

/**
 * Reports Routes.
 */
(function (Routing\RouteCollection $routes) {
    $routes->add('reports', new Routing\Route('/admin/reports', [
        '_controller' => [App\Controller\ReportsController::class, 'showAction'],
    ]));

    $routes->add('reports_update', new Routing\Route('/admin/reports/create', [
        '_controller' => [App\Controller\ReportsController::class, 'updateAction'],
    ]));

    $routes->add('reports_invoice', new Routing\Route('/admin/reports/print/{userId}/{orderId}', [
        '_controller' => [App\Controller\ReportsController::class, 'invoiceAction'],
    ]));
})($routes);

return $routes;
