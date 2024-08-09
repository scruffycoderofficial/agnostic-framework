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

use CoolStuff\Shared\Entity\Order;
use PHPMentors\DomainKata\Entity\EntityInterface;
use CoolStuff\Component\Repository\Contract\ORMRepository;
use CoolStuff\Component\Repository\Doctrine\DoctrineORMRepository;

/**
 * Class InvoiceRepository.
 *
 * @package CoolStuff\App\Common\Repository
 */
class InvoiceRepository extends DoctrineORMRepository implements InvoiceRepositoryInterface
{
    public function getIterator(): \Iterator
    {
        // TODO: Implement getIterator() method.
    }

    public function slice(int $start, int $size = 20): ORMRepository
    {
        // TODO: Implement slice() method.
    }

    public function count(): int
    {
        // TODO: Implement count() method.
    }

    public function add(EntityInterface $entity)
    {
        // TODO: Implement add() method.
    }

    public function remove(EntityInterface $entity)
    {
        // TODO: Implement remove() method.
    }

    public function getAll(int $userId): array
    {
        // TODO: Implement getAll() method.
    }

    public function prepareInvoice(int $userId, int $orderId): Order
    {
        // TODO: Implement prepareInvoice() method.
    }

    public function prepareOrderItems(int $orderId): array
    {
        // TODO: Implement prepareOrderItems() method.
    }
}
