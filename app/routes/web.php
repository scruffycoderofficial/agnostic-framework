<?php
/*
 * This file is part of the D6 Assessment Project.
 *
 * (c) Luyanda Siko <sikoluyanda@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

$routes = $container->get(RouteCollection::class);

$routes->add('reports', new Route('/reports', [
    '_controller' => ['\D6\Invoice\App\Controller\ReportsController::listAction'],
]));
