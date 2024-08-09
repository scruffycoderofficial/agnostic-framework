<?php
/*
 * This file is part of the CoolStuff Enterprise Project.
 *
 * (c) Luyanda Siko <sikoluyanda@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

declare(strict_types=1);

namespace CoolStuff\Component\Logger;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;

/**
 * Class LoggerExtension.
 *
 * @package CoolStuff\Component\Logger
 */
final class LoggerExtension implements ExtensionInterface
{
    public function load(array $configs, ContainerBuilder $container)
    {
        (new PhpFileLoader($container, new FileLocator(__DIR__.'/Resources/config')))
            ->load('services.php');
    }

    public function getNamespace(): string
    {
        return __NAMESPACE__;
    }

    public function getXsdValidationBasePath(): bool|string
    {
        return false;
    }

    public function getAlias(): string
    {
        return 'logger';
    }
}
