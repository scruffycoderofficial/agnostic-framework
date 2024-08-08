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

namespace CoolStuff\Component\Service\WebScraper;

use Goutte\Client;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Class WebScraper.
 *
 * @package CoolStuff\Component\Service\WebScraper
 */
abstract class WebScraper
{
    /**
     * WebScraper constructor.
     */
    public function __construct(protected Client $client, protected bool $onlineStatus, protected string $scrapingPath)
    {
    }

    /**
     * Returns the current WebScraper's name.
     */
    abstract public function getBrand(): string;

    /**
     * Returns this WebScraper Content Page's Crawler instance.
     *
     * @param string $method
     */
    protected function getContentPage($url, $method = 'GET'): Crawler
    {
        return $this->client->request($method, $url);
    }

    protected function offlineContentPage(string $filePath, string $brand): Crawler
    {
        return new Crawler(@file_get_contents(sprintf('%s/%s.html', $filePath, $brand)));
    }
}
