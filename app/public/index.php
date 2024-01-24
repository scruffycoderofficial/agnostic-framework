<?php
/*
 * This file is part of the D6 Assessment Project.
 *
 * (c) Luyanda Siko <sikoluyanda@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

require_once __DIR__.'/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;

/**
 * Turn on the lights if in local and/or testing environments
 */
if (in_array(getenv('APP_ENV'), ['test', 'local'])) {
    ini_set('display_errors', 1);
    error_reporting(-1);
}

$container = include __DIR__.'/../bootstrap/app.php';

$request = Request::createFromGlobals();

$response = $container->get('kernel')->handle($request);

$response->send();
