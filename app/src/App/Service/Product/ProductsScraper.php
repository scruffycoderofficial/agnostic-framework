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

namespace CoolStuff\App\Service\Product;

/**
 * Class ProductsScraper.
 *
 * @package CoolStuff\App\Service\Product
 */
class ProductsScraper
{
    public function __construct(private ProductsScraperContext $productsScraperContext)
    {
    }

    public function handle($brand): ?array
    {
        return $this->productsScraperContext->handle($brand);
    }
}
