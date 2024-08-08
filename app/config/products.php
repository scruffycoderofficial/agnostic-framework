<?php
/*
 * This file is part of the CoolStuff Enterprise Project.
 *
 * (c) Luyanda Siko <sikoluyanda@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Goutte\Client;
use CoolStuff\Shared\Service\Product\ProductsScraper;
use CoolStuff\Component\Service\WebScraper\WebScraper;
use CoolStuff\App\Service\Product\OnlineProductsSyncer;
use CoolStuff\Shared\Repository\ProductRepositoryInterface;
use CoolStuff\Shared\Service\Product\ProductsScraperContext;
use CoolStuff\Shared\Service\Product\Brand\NewProductsScraper;
use CoolStuff\Shared\Service\Product\Brand\CraftProductsScraper;
use CoolStuff\Shared\Service\Product\Brand\LocalProductsScraper;
use CoolStuff\Shared\Service\Product\Brand\GlobalProductsScraper;

return static function (ContainerConfigurator $container): void {
    $services = $container->services();

    $services->set(ProductsScraperContext::class)
        ->public();

    $services->set(ProductsScraper::class)
        ->arg('$productsScraperContext', service(ProductsScraperContext::class));

    $services->set(WebScraper::class)
        ->arg('$client', service(Client::class))
        ->arg('$onlineStatus', '%app.online_status%')
        ->arg('$scrapingPath', '%app.products.scraping_path%')
        ->abstract(true);

    $services->set(NewProductsScraper::class)
        ->parent(WebScraper::class)
        ->tag('app.web_scraper.products');

    $services->set(LocalProductsScraper::class)
        ->parent(WebScraper::class)
        ->tag('app.web_scraper.products');

    $services->set(CraftProductsScraper::class)
        ->parent(WebScraper::class)
        ->tag('app.web_scraper.products');

    $services->set(GlobalProductsScraper::class)
        ->parent(WebScraper::class)
        ->tag('app.web_scraper.products');

    $services->set(OnlineProductsSyncer::class)
        ->args([
            service(ProductsScraper::class),
            service(ProductRepositoryInterface::class),
        ]);
};
