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

namespace CoolStuff\Suppliers\Persistence\Doctrine\Repository;

use CoolStuff\Suppliers\Domain\Repository\SupplierRepository as PartnerRepositoryInterface;

/**
 * Class PartnerRepository.
 *
 * @package CoolStuff\Suppliers\Persistence\Doctrine\Repository
 */
final class SupplierRepository extends AbstractDoctrineRepository implements PartnerRepositoryInterface
{
    protected string $entityClass = Order::class;

    public function getSponsoring(): array
    {
        // TODO: Implement getSponsoring() method.
    }

    public function getOnboarded(): array
    {
        // TODO: Implement getOnboarded() method.
    }

    public function getDoormat(): array
    {
        // TODO: Implement getDoormat() method.
    }
}
