<?php
/*
 * This file is part of the CoolStuff Enterprise Project.
 *
 * (c) Luyanda Siko <sikoluyanda@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use Psr\Log\LoggerInterface;
use CoolStuff\Component\HttpKernel\Kernel;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\HttpFoundation\UrlHelper;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\DependencyInjection\Reference;
use CoolStuff\Component\EventListener\LocaleListener;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Generator\UrlGenerator;
use CoolStuff\Component\Controller\ControllerResolver;
use CoolStuff\Component\EventListener\LoggingListener;
use Symfony\Component\HttpKernel\Fragment\FragmentHandler;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use CoolStuff\Component\EventListener\RequestSessionListener;
use CoolStuff\Component\EventListener\StringResponseListener;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpKernel\EventListener\ErrorListener;
use Symfony\Component\HttpKernel\EventListener\RouterListener;
use Symfony\Component\HttpKernel\EventListener\ResponseListener;

/* @var ContainerBuilder $container */
$container->register('request_context', RequestContext::class);

$routeCollection = include_once __DIR__.'/../routes/web.php';

$container->register('matcher', UrlMatcher::class)
    ->setArguments([$routeCollection, new Reference('request_context')]);

$container->register('url_generator', UrlGenerator::class)
    ->setArguments([
        $routeCollection,
        new Reference('request_context'),
        new Reference(LoggerInterface::class),
    ])
    ->setPublic(true);

$container->register('request_stack', RequestStack::class)
    ->setPublic(true);

$container->register(UrlHelper::class)
    ->setArgument('$requestStack', new Reference('request_stack'))
    ->setArgument('$requestContext', new Reference('request_context'));

$container->register(ControllerResolver::class)
    ->setArguments([
        $container,
        new Reference(LoggerInterface::class),
    ]);

$container->register(FragmentHandler::class)
    ->setArgument('$requestStack', new Reference('request_stack'));

$container->register(ArgumentResolver::class);

$container->register(ResponseListener::class)
    ->setArguments(['%app.charset%']);

$container->register(ErrorListener::class)
    ->setArguments(['CoolStuff\Component\Controller\ErrorController::exception']);

$container->register(LocaleListener::class)
    ->setArgument('$container', new Reference('service_container'))
    ->setArgument('$requestStack', new Reference('request_stack'))
    ->setArgument('$requestContext', new Reference('request_context'));

$container->register(StringResponseListener::class);

$container->register(LoggingListener::class)
    ->setArgument('$logger', new Reference(LoggerInterface::class));

$container->register(RouterListener::class)
    ->setArguments([
        new Reference('matcher'),
        new Reference('request_stack'),
    ]);

$container->register(RequestSessionListener::class)
    ->setArgument('$session', new Reference(Session::class));

$container->register(Kernel::class)
    ->setArguments([
        new Reference('event_dispatcher'),
        new Reference(ControllerResolver::class),
        new Reference('request_stack'),
        new Reference(ArgumentResolver::class),
    ])
    ->setPublic(true);
