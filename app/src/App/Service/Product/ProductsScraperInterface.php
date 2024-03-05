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
 * Interface ProductsScraperInterface.
 *
 * @package CoolStuff\App\Service\Product
 */
interface ProductsScraperInterface
{
    /**
     * Source URL to collect list of products from.
     */
    public const TARGET_URL = 'https://www.sab.co.za/brands';

    /**
     * Checks if given brand is supported.
     *
     * @param string $brand
     * @return bool
     */
    public function supports(string $brand): bool;

    /**
     * Processes the products of a given brand.
     *
     * @param string $brand
     * @return array|null
     */
    public function process(string $brand): ?array;
}
