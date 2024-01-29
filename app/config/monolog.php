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
use D6\Invoice\Component\Logger\LoggerDecorator;
use Symfony\Component\DependencyInjection\Reference;

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
