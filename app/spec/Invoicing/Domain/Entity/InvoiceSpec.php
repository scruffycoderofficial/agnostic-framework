<?php
/*
 * This file is part of the CoolStuff Enterprise Project.
 *
 * (c) Luyanda Siko <sikoluyanda@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace spec\CoolStuff\Invoicing\Domain\Entity;

use PhpSpec\ObjectBehavior;
use CoolStuff\Component\Entity\Entity;
use CoolStuff\Invoicing\Domain\Entity\Order;
use CoolStuff\Invoicing\Domain\Entity\Invoice;
use CoolStuff\Invoicing\Domain\Entity\Customer;

/**
 * Class InvoiceSpec.
 *
 * @package spec\CoolStuff\Invoicing\Domain\Entity
 */
class InvoiceSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(Invoice::class);
    }

    public function it_is_an_entity()
    {
        $this->shouldBeAnInstanceOf(Entity::class);
    }

    public function it_has_an_order()
    {
        $customer = (new Customer())
            ->setName('John Doe')
            ->setEmail('john.d@acme-corp.co.za');

        $order = (new Order())
            ->setCustomer($customer)
            ->setDescription('Bought Carling Black Label on credit @ R30 (excl. VAT) for 1.')
            ->setRefNumber('20240330-2010-8778')
            ->setTotal(30.0);

        $this->setOrder($order);

        $this->getOrder()
            ->shouldHaveType(Order::class);
    }

    public function it_has_date_issued()
    {
        $this->setDateIssued(new \DateTime('now'));

        $this->getDateIssued()
            ->shouldHaveType(\DateTime::class);
    }

    public function it_has_total()
    {
        $this->setTotal(30.0);

        $this->getTotal()
            ->shouldBe(30.0);
    }
}
