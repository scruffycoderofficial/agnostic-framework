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

/**
 * Class LocalProductsWebScraper.
 *
 * @package CoolStuff\App\Service\Product\WebScraper
 */
final class LocalProductsScraper extends WebScraper implements ProductsScraperInterface
{
    /**
     * The brand name to scrape from the target source.
     */
    private const BRAND_NAME = 'local';

    /**
     * The targeted Content Page.
     *
     * @return string
     */
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
        $data = null;
        if (! $this->onlineStatus) {
            $data = $this->offlineContentPage($this->scrapingPath, $brand);
        } else {
            $data = $this->getContentPage($brand);
        }

        return $this->collect($data);
    }

    /**
     * @param $node
     * @return string
     */
    protected function title($node): string
    {
        return $node->filter('.views-field.views-field-title, span .field-content')
            ->text();
    }

    /**
     * Returns an array of a typical body parts item: tagline and description.
     *
     * @param $node
     * @return string[]
     */
    protected function body($node): array
    {
        $parts = $node->filter('.views-field.views-field-body, .field-content')
            ->children('p')
            ->each(function ($node) {
                return $node->text();
            });

        $tagline = $description = '';

        if (count($parts) > 2) {
            $tagline = $parts[0];
            $description = $parts[1];
        } elseif (count($parts) === 2) {
            $description = $parts[0];
        }

        return [
            'tagline' => $tagline,
            'description' => $description,
        ];
    }

    /**
     * Returns a list of a typical Product ingredients, e.g ['foo', 'bar', 'baz'].
     *
     * @param $node
     * @return array
     */
    protected function ingredients($node): array
    {
        $ingredients = $node->filter('.views-field.views-field-field-brand-ingredients')
            ->each(function ($node) {
                return $node->filter('.field-content, p')->text();
            });

        return $ingredients;
    }

    /**
     * Returns an array list of nutritional information in below format:
     *   [
     *      ['label' => '5%', 'value' => 'Alcohol by volume %.'],
     *      ['label' => 'foo', 'value' => 'bar']
     *   ]
     *
     * @param $node
     * @return array
     */
    protected function nutritionalInfo($node): array
    {
        $nutritionalItems = [];

        $node->filter('.views-field.views-field-field-brand-nutritional-info')
            ->each(function ($node) use (&$nutritionalItems) {
                $node->filter('.field-content, ul')
                    ->siblings('li')->each(function ($node) use (&$nutritionalItems) {
                        array_map(function ($entry) use (&$nutritionalItems) {
                            $item = trim($entry);
                            if ($item !== '') {
                                array_push($nutritionalItems, $item);
                            }
                        }, explode("\n", $node->html()));
                    });
            });

        return $nutritionalItems;
    }

    /**
     * Collects and returns a list of Products.
     *
     * @param Crawler $givenContent
     * @return array
     */
    private function collect(Crawler $givenContent): array
    {
        $items = [];

        $givenContent->filter('.slider-component')
            ->first()
            ->children('li')
            ->each(function ($listChildItem) use (&$items) {
                array_push($items, [
                    'title' => $this->title($listChildItem),
                    'tagline' => $this->body($listChildItem)['tagline'],
                    'description' => $this->body($listChildItem)['description'],
                    'ingredients' => $this->ingredients($listChildItem),
                    'nutritional_info' => $this->nutritionalInfo($listChildItem),
                ]);
            });

        return $items;
    }
}
