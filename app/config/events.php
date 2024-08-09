<?php
/*
 * This file is part of the CoolStuff Enterprise Project.
 *
 * (c) Luyanda Siko <sikoluyanda@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use Symfony\Component\DependencyInjection\Reference;
use CoolStuff\Component\EventListener\LocaleListener;
use CoolStuff\Component\EventListener\LoggingListener;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Mailer\EventListener\MessageListener;
use CoolStuff\Component\EventListener\StringResponseListener;
use Symfony\Component\HttpKernel\EventListener\ErrorListener;
use Symfony\Component\HttpKernel\EventListener\RouterListener;
use Symfony\Component\HttpKernel\EventListener\ResponseListener;

/* @var ContainerBuilder $container */

$container->register('event_dispatcher', EventDispatcher::class)
    ->addMethodCall('addSubscriber', [new Reference(ResponseListener::class)])
    ->addMethodCall('addSubscriber', [new Reference(RouterListener::class)])
    ->addMethodCall('addSubscriber', [new Reference(ErrorListener::class)])
    ->addMethodCall('addSubscriber', [new Reference(LocaleListener::class)])
    ->addMethodCall('addSubscriber', [new Reference(StringResponseListener::class)])
    ->addMethodCall('addSubscriber', [new Reference(LoggingListener::class)])
    /**->addMethodCall('addSubscriber', [new Reference(MessageListener::class)])*/;
