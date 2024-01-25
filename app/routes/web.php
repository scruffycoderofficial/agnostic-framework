<?php
/*
 * This file is part of the D6 Assessment Project.
 *
 * (c) Luyanda Siko <sikoluyanda@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use Symfony\Component\Routing;

$routes = new Routing\RouteCollection();

$routes->add('login', new Routing\Route('/login', [
    '_controller' => [D6\Invoice\App\Controller\AuthController::class, 'login'],
]));

return $routes;
