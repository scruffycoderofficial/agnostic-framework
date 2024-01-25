<?php
/*
 * This file is part of the D6 Assessment Project.
 *
 * (c) Luyanda Siko <sikoluyanda@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use Monolog\Logger;
use Psr\Log\LoggerInterface;
use Psr\Log\LoggerAwareInterface;
use Monolog\Handler\StreamHandler;
use Symfony\Component\Config\FileLocator;
use D6\Invoice\Component\HttpKernel\Kernel;
use Symfony\Component\Routing\RequestContext;
use D6\Invoice\Component\Logger\LoggerDecorator;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpKernel\EventListener\ErrorListener;
use Symfony\Component\HttpKernel\EventListener\RouterListener;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
use Symfony\Component\HttpKernel\EventListener\ResponseListener;
use Symfony\Component\HttpKernel\Controller\ContainerControllerResolver;
use D6\Invoice\Component\HttpKernel\EventListener\StringResponseListener;

$container = new ContainerBuilder();

/**
 * Parameter definitions
 */
$container->setParameter('debug', getenv('APP_DEBUG'));
$container->setParameter('charset', 'UTF-8');
$container->setParameter('db.params', [
    'dbname' => getenv('DB_DATABASE'),
    'user' => getenv('DB_USERNAME'),
    'password' => getenv('DB_PASSWORD'),
    'host' => getenv('DB_HOST'),
    'driver' => 'pdo_mysql',
]);
$container->setParameter('root_dir', __DIR__.'/..');
$container->setParameter('app.logger.channel', 'daily');
$container->setParameter('app.logger.file_path', '%root_dir%/var/log/app.log');

// Assumption is that user email already exists in database
$container->setParameter('admin.user.email', getenv('ADMIN_USER_EMAIL'));

/**
 * Monolog definitions
 */
$container->register(StreamHandler::class, StreamHandler::class)
    ->addArgument('%app.logger.file_path%');

$container->register(LoggerInterface::class, Logger::class)
    ->addArgument('%app.logger.channel%')
    ->addMethodCall('pushHandler', [new Reference(StreamHandler::class)]);

$container->registerForAutoconfiguration(LoggerAwareInterface::class)
    ->addMethodCall('setLogger', [new Reference(LoggerInterface::class)]);

$container->register(LoggerDecorator::class)
    ->setDecoratedService(LoggerInterface::class)
    ->addArgument(new Reference(LoggerDecorator::class.'.inner'));

/**
 * HttpKernel dependency definitions
 */
$container->register('context', RequestContext::class);

$container->register('matcher', UrlMatcher::class)
    ->setArguments([include_once __DIR__.'/../routes/web.php', new Reference('context')]);

$container->register('request_stack', RequestStack::class);

$container->register('controller_resolver', ContainerControllerResolver::class)
    ->setArguments([$container, new Reference(LoggerInterface::class)]);

$container->register('argument_resolver', ArgumentResolver::class);

$container->register('listener.router', RouterListener::class)
    ->setArguments([new Reference('matcher'), new Reference('request_stack')]);

/**
 * Event Listener definitions
 */
$container->register('listener.response', ResponseListener::class)
    ->setArguments(['%charset%']);

$container->register('listener.exception', ErrorListener::class)
    ->setArguments(['D6\Invoice\App\Controller\ErrorController::exception']);

$container->register('listener.string_response', StringResponseListener::class);

/**
 * Event Dispatcher definition with listeners/subscribers attached
 */
$container->register('dispatcher', EventDispatcher::class)
    ->addMethodCall('addSubscriber', [new Reference('listener.router')])
    ->addMethodCall('addSubscriber', [new Reference('listener.response')])
    ->addMethodCall('addSubscriber', [new Reference('listener.exception')]);

/**
 * Event Dispatcher update via `getDefinition` method to add new Listener
 */
$container->getDefinition('dispatcher')
    ->addMethodCall('addSubscriber', [new Reference('listener.string_response')]);

/**
 * HttpKernel implementation
 */
$container->register('kernel', Kernel::class)
    ->setArguments([
        new Reference('dispatcher'),
        new Reference('controller_resolver'),
        new Reference('request_stack'),
        new Reference('argument_resolver'),
    ])
    ->setPublic(true);

/**
 * Load the rest of the pre-existing configuration files
 */
$loader = new PhpFileLoader($container, new FileLocator(__DIR__.'/../config'));
$loader->load('app.php');
$loader->load('console.php');
$loader->load('database.php');
$loader->load('views.php');

/**
 * Compile the container, if not compiled
 */
if (! $container->isCompiled()) {
    $container->compile();
}

return $container;
