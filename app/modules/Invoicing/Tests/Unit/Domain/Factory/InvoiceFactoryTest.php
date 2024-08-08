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

namespace CoolStuff\Invoicing\Tests\Unit\Domain\Factory;

use PHPUnit\Framework\TestCase;
use CoolStuff\Invoicing\Domain\Entity\Order;
use CoolStuff\Customers\Domain\Entity\Customer;
use CoolStuff\Invoicing\Domain\Factory\InvoiceFactory;

/**
 * Class InvoiceFactoryTest.
 *
 * @package CoolStuff\Invoicing\Tests\Domain\Factory
 */
class InvoiceFactoryTest extends TestCase
{
    public function testItCanCreateAnInvoiceFromAnOrder()
    {
        $customer = (new Customer())
            ->setName('John Doe')
            ->setEmail('john.d@acme-corp.co.za');

        $order = (new Order())
            ->setCustomer($customer)
            ->setDescription('Bought Carling Black Label on credit @ R60 (excl. VAT) for 2.')
            ->setRefNumber('20240329-2010-8771')
            ->setTotal(60.00);

        $invoice = (new InvoiceFactory())
            ->createFromOrder($order);

        self::assertSame('John Doe', $order->getCustomer()->getName());
        self::assertSame(60.00, $invoice->getTotal());
    }
}
