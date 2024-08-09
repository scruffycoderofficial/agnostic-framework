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

namespace CoolStuff\Shared\Repository;

use CoolStuff\Shared\Entity\Product;
use PHPMentors\DomainKata\Entity\EntityInterface;

/**
 * Interface ProductRepositoryInterface.
 *
 * @package CoolStuff\App\Common\Repository
 */
interface ProductRepositoryInterface
{
    public function all();

    public function add(EntityInterface $product): void;

    public function update(EntityInterface $product): bool;

    public function remove(EntityInterface $product): void;

    public function ofId(int $productId): ?Product;

    public function withActiveStatus(): self;

    public function registeredAfter(\DateTimeInterface $date): self;

    public function registeredBefore(\DateTimeInterface $date): self;
}
