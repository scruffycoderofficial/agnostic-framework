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

namespace CoolStuff\Invoicing\Domain\Repository;

use CoolStuff\Invoicing\Domain\Entity\Order;

/**
 * Interface OrderRepository.
 *
 * @package CoolStuff\Invoicing\Domain\Repository
 */
interface OrderRepository extends Repository
{
    /**
     * @return Order[]
     */
    public function getUnInvoicedOrders(): array;
}
