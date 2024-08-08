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

namespace CoolStuff\Invoicing\Persistence\Doctrine\Repository;

use CoolStuff\Invoicing\Domain\Entity\Order;
use CoolStuff\Invoicing\Domain\Entity\Invoice;
use CoolStuff\Invoicing\Domain\Repository\OrderRepository as OrderRepositoryInterface;

/**
 * Class OrderRepository.
 *
 * @package CoolStuff\Invoicing\Persistence\Doctrine\Repository
 */
final class OrderRepository extends AbstractDoctrineRepository implements OrderRepositoryInterface
{
    protected string $entityClass = Order::class;

    public function getUnInvoicedOrders()
    {
        $builder = $this->entityManager->createQueryBuilder()
            ->select('o')
            ->from($this->entityClass, 'o')
            ->leftJoin(
                Invoice::class,
                'i',
                Join::WITH,
                'i.order = o'
            )
            ->where('i.id IS NULL');

        return $builder->getQuery()->getResult();
    }
}
