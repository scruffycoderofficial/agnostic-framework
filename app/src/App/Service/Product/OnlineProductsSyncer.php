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

use CoolStuff\App\Factory\Product\ProductFactory;
use CoolStuff\Shared\Service\Product\ProductsScraper;
use CoolStuff\Shared\Repository\ProductRepositoryInterface;

/**
 * Class OnlineProductsSyncer.
 *
 * @package CoolStuff\App\Service\Product
 */
final class OnlineProductsSyncer
{
    /**
     * OnlineProductsSyncer constructor.
     */
    public function __construct(
        private ProductsScraper $productsScraper,
        private ProductRepositoryInterface $productRepository,
    ) {
    }

    public function updateBrand(string $brand): void
    {
        $products = $this->productsScraper->handle($brand);

        if (! is_null($products)) {
            array_map(function ($productData) use ($brand) {
                $this->productRepository->add(
                    ProductFactory::createFromArray($brand, $productData)
                );
            }, $products);
        }
    }
}
