<?php
/*
 * This file is part of the CoolStuff Enterprise Project.
 *
 * (c) Luyanda Siko <sikoluyanda@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace spec\CoolStuff\Invoicing\Domain\Factory;

use PhpSpec\ObjectBehavior;
use CoolStuff\Invoicing\Domain\Entity\Order;
use CoolStuff\Invoicing\Domain\Entity\Invoice;
use CoolStuff\Invoicing\Domain\Entity\Customer;
use CoolStuff\Invoicing\Domain\Factory\InvoiceFactory;

/**
 * Class InvoiceFactorySpec.
 *
 * @package spec\CoolStuff\Invoicing\Domain\Factory
 */
class InvoiceFactorySpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(InvoiceFactory::class);
    }

    public function it_creates_an_invoice_from_order()
    {
        $customer = (new Customer())
            ->setName('John Doe')
            ->setEmail('john.d@acme-corp.co.za');

        $order = (new Order())
            ->setCustomer($customer)
            ->setDescription('Bought Carling Black Label on credit @ R60 (excl. VAT) for 2.')
            ->setRefNumber('20240329-2010-8771')
            ->setTotal(60.0);

        $this->createFromOrder($order)
            ->shouldHaveType(Invoice::class);
    }
}
