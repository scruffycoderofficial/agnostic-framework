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
use Doctrine\ORM\EntityManagerInterface;
use CoolStuff\App\Service\Product\ProductsScraper;
use CoolStuff\App\Common\Repository\ProductRepository;
use CoolStuff\Component\Service\WebScraper\WebScraper;
use CoolStuff\App\Service\Product\ProductsScraperContext;
use CoolStuff\App\Service\Product\Brand\NewProductsScraper;
use CoolStuff\App\Service\Product\Brand\CraftProductsScraper;
use CoolStuff\App\Service\Product\Brand\LocalProductsScraper;
use CoolStuff\App\Service\Product\Brand\GlobalProductsScraper;
use CoolStuff\App\Common\Repository\ProductRepositoryInterface;

return static function (ContainerConfigurator $container): void {
    $services = $container->services();

    /*
     * Web Scraper Context (Strategy Design Pattern entry)
     */
    $services->set(ProductsScraperContext::class)->public();

    $services->set(ProductsScraper::class)
        ->arg('$productsScraperContext', service(ProductsScraperContext::class));

    $services->set(WebScraper::class)
        ->arg('$client', service(Client::class))
        ->arg('$onlineStatus', '%app.online_status%')
        ->arg('$scrapingPath', '%app.products.scraping_path%')
        ->abstract(true);

    /*
     * Web Scraper strategies
     */
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

    /*
     * Repository configurations
     */
    $services->set(ProductRepository::class)
        ->arg('$manager', service(EntityManagerInterface::class));

    $services->alias(ProductRepositoryInterface::class, ProductRepository::class);
};
