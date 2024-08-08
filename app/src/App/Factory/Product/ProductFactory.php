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

namespace CoolStuff\App\Factory\Product;

use CoolStuff\Shared\Entity\Product;
use CoolStuff\App\ToolKit\Product\AvailableProducts;

/**
 * Class ProductFactory.
 *
 * @package CoolStuff\App\Factory\Product
 */
final class ProductFactory
{
    public static function createFromArray(string $brand, array $data): Product
    {
        $product = new Product();

        $isActive = false;
        if (in_array($data['title'], AvailableProducts::ACTIVE_LIST[$brand])) {
            $isActive = true;
        }

        if (! isset($data['collected_on'])) {
            $data['collected_on'] = new \DateTime('now');
        }

        $product
            ->setName($data['title'])
            ->setTagline($data['tagline'])
            ->setDescription($data['description'])
            ->setBrand($brand)
            ->setActive($isActive)
            ->setLastCollectedOn($data['collected_on']);

        return $product;
    }
}
