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

namespace CoolStuff\Shared\Service\Product;

/**
 * Class ProductsScraperContext.
 *
 * @package CoolStuff\Shared\Service\Product
 */
final class ProductsScraperContext
{
    /**
     * Holds a list of Scrapers for this context.
     */
    private array $scrapers = [];

    /**
     * Adds a new WebScraperService strategy implementing
     * a ProductsScraperInterface.
     */
    public function addWebScraper(ProductsScraperInterface $webScraperService)
    {
        $this->scrapers[] = $webScraperService;
    }

    /**
     * Handles the scraping process for a given product brand
     * within the context only if it supports it.
     */
    public function handle($brand): ?array
    {
        foreach ($this->scrapers as $scraper) {
            if ($scraper->supports($brand)) {
                return $scraper->process($brand);
            }
        }

        return null;
    }
}
