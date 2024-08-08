<?php
/*
 * This file is part of the CoolStuff Enterprise Project.
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
use Monolog\Handler\NativeMailerHandler;
use Symfony\Component\DependencyInjection\Reference;
use CoolStuff\Component\Logger\Decorator\FancyLogger;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/* @var ContainerBuilder $container */
$container->register(StreamHandler::class, StreamHandler::class)
    ->addArgument('%app.logger.file_path%');

$container->register(NativeMailerHandler::class)
    ->addArgument(getenv('MAIL_TO_ADDRESS'))
    ->addArgument('System Log Entry from '.getenv('APP_ENV'))
    ->addArgument(getenv('MAIL_FROM_ADDRESS'));

$container->register(LoggerInterface::class, Logger::class)
    ->addArgument('%app.logger.channel%')
    ->addMethodCall('pushHandler', [new Reference(StreamHandler::class)])
    ->addMethodCall('pushHandler', [new Reference(NativeMailerHandler::class)]);

$container->registerForAutoconfiguration(LoggerAwareInterface::class)
    ->addMethodCall('setLogger', [new Reference(LoggerInterface::class)]);

$container->register(FancyLogger::class)
    ->setDecoratedService(LoggerInterface::class)
    ->addArgument(new Reference(FancyLogger::class.'.inner'));
