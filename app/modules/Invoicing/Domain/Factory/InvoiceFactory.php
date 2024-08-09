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

namespace CoolStuff\Invoicing\Domain\Factory;

use CoolStuff\Invoicing\Domain\Entity\Order;
use CoolStuff\Invoicing\Domain\Entity\Invoice;

/**
 * Class InvoiceFactory.
 *
 * @package CoolStuff\Invoicing\Domain\Factory
 */
class InvoiceFactory
{
    public function createFromOrder(Order $order): Invoice
    {
        $invoice = new Invoice();

        $invoice
            ->setOrder($order)
            ->setDateIssued(new \DateTime('now'))
            ->setTotal($order->getTotal());

        return $invoice;
    }
}
