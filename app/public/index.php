<?php
/*
 * This file is part of the CoolStuff Enterprise Project.
 *
 * (c) Luyanda Siko <sikoluyanda@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

require_once __DIR__.'/../vendor/autoload.php';

use Symfony\Component\ErrorHandler\Debug;
use Symfony\Component\HttpFoundation\Request;
use CoolStuff\Component\Foundation\Application;
use Symfony\Component\ErrorHandler\ErrorHandler;

/*
 * Turn on the lights if in local and/or testing environments
 */
if (in_array(getenv('APP_ENV'), ['testing', 'local'])) {
    ini_set('display_errors', 1);
    error_reporting(-1);

    Debug::enable();

    /*
     * Register Error handling
     */
    ErrorHandler::register();
}

(new Application(require_once __DIR__.'/../bootstrap/app.php'))
    ->run(Request::createFromGlobals());
