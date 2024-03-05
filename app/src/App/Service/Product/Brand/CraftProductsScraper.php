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

namespace CoolStuff\App\Service\Product\Brand;

use Symfony\Component\DomCrawler\Crawler;
use CoolStuff\Component\Service\WebScraper\WebScraper;
use CoolStuff\App\Service\Product\ProductsScraperInterface;

final class CraftProductsScraper extends WebScraper implements ProductsScraperInterface
{
    /**
     * The brand name to scrape from the target source.
     */
    private const BRAND_NAME = 'craft';

    public function getBrand(): string
    {
        return self::BRAND_NAME;
    }

    public function supports(string $brand): bool
    {
        return self::BRAND_NAME === $brand;
    }

    /**
     * Collects local brand products and return information on each.
     *
     * @param string $brand
     * @return array|null
     */
    public function process(string $brand): ?array
    {
        return $this->collect($this->getContentPage($brand));
    }

    private function collect(Crawler $subject): array
    {
        // TODO: Implement collect() method.
    }
}
