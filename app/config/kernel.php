<?php
/*
 * This file is part of the D6 Assessment Project.
 *
 * (c) Luyanda Siko <sikoluyanda@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use Psr\Log\LoggerInterface;
use D6\Invoice\Component\HttpKernel\Kernel;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpKernel\Controller\ContainerControllerResolver;

/**
 * HttpKernel definitions
 */
$container->register('context', RequestContext::class);

$container->register('matcher', UrlMatcher::class)
    ->setArguments([include_once __DIR__.'/../routes/web.php', new Reference('context')]);

$container->register('request_stack', RequestStack::class)
    ->setPublic(true);

$container->register('controller_resolver', ContainerControllerResolver::class)
    ->setArguments([$container, new Reference(LoggerInterface::class)]);

$container->register('argument_resolver', ArgumentResolver::class);

$container->register('kernel', Kernel::class)
    ->setArguments([
        new Reference('dispatcher'),
        new Reference('controller_resolver'),
        new Reference('request_stack'),
        new Reference('argument_resolver'),
    ])
    ->setPublic(true);
