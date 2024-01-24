<?php
/*
 * This file is part of the D6 Assessment Project.
 *
 * (c) Luyanda Siko <sikoluyanda@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use Symfony\Component\ErrorHandler\Debug;
use Symfony\Component\HttpKernel\HttpKernel;
use Symfony\Component\HttpFoundation\Request;

require_once __DIR__.'/../vendor/autoload.php';

/**
 * Only enable DEBUG if we within the specified environments below
 */
if (in_array(getenv('APP_ENV'), ['local', 'test']) && getenv('APP_DEBUG') === true) {
    Debug::enable();
}

/*
|--------------------------------------------------------------------------
| Run The Application
|--------------------------------------------------------------------------
|
| Once we have the application, we can handle the incoming request using
| the application's HTTP kernel. Then, we will send the response back
| to this client's browser, allowing them to enjoy our application.
|
*/
require_once __DIR__.'/../bootstrap/app.php';

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These routes
| are handled by Symfony Routing component.
|
| Let us to make something great!
|
*/
require_once __DIR__.'/../routes/web.php';

/*
|--------------------------------------------------------------------------
| Run The Application
|--------------------------------------------------------------------------
|
| Once we have the application, we can handle the incoming request using
| the application's HTTP kernel. Then, we will send the response back
| to this client's browser, allowing them to enjoy our application.
|
*/
$request = Request::createFromGlobals();

try {
    $kernel = $container->get(HttpKernel::class);

    $response = $kernel->handle($request);

    $response->send();

    $kernel->terminate($request, $response);
} catch (Exception $exc) {
}
