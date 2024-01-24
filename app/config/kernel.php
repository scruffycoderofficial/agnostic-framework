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

use Psr\Log\LoggerInterface;
use Psr\Http\Message\RequestInterface;
use Symfony\Component\HttpKernel\HttpKernel;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpKernel\EventListener\RouterListener;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;

/**
 * @see https://symfony.com/doc/current/components/http_kernel.html#a-full-working-example
 */
return static function (ContainerConfigurator $container): void {
    $services = $container->services();

    $services->set(RouteCollection::class)
        ->public();

    $services->set(Request::class)
        ->factory([Request::class, 'createFromGlobals'])
        ->public();

    $services->alias(RequestInterface::class, Request::class)
        ->public();

    $services->set(RequestContext::class)
        ->public();

    $services->set(UrlMatcher::class)
        ->args([
            service(RouteCollection::class),
            service(RequestContext::class),
        ])
        ->public();

    $services->set(RequestStack::class)
        ->public();

    $services->set(RouterListener::class)
        ->args([
            service(UrlMatcher::class),
            service(RequestStack::class),
        ])
        ->public();

    $services->set(EventDispatcherInterface::class, EventDispatcher::class)
        ->call('addSubscriber', [service(RouterListener::class)])
        ->public();

    $services->set(ControllerResolver::class)
        ->arg('$logger', service(LoggerInterface::class))
        ->public();

    $services->set(ArgumentResolver::class)
        ->public();

    $services->set(HttpKernel::class)
        ->args([
            service(EventDispatcherInterface::class),
            service(ControllerResolver::class),
            service(RequestStack::class),
            service(ArgumentResolver::class),
        ])
        ->public();

    $services->set(Response::class)
        ->public();
};
