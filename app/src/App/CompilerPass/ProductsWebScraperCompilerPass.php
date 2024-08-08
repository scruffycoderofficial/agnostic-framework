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

namespace CoolStuff\App\CompilerPass;

use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use CoolStuff\Shared\Service\Product\ProductsScraperContext;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

/**
 * Class ProductsWebScraperCompilerPass
 *
 * @package CoolStuff\App\CompilerPass
 */
final class ProductsWebScraperCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        $contextDefinition = $container->findDefinition(ProductsScraperContext::class);

        foreach (array_keys($container->findTaggedServiceIds('app.web_scraper.products')) as $strategyServiceId) {
            $contextDefinition->addMethodCall('addWebScraper', [new Reference($strategyServiceId)]);
        }
    }
}
