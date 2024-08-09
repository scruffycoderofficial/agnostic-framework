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
use CoolStuff\Invoicing\Domain\Entity\Customer;

/**
 * Class OrderSpec.
 *
 * @package spec\CoolStuff\Invoicing\Domain\Entity
 */
class OrderSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(Order::class);
    }

    public function it_is_an_entity()
    {
        $this->shouldBeAnInstanceOf(Entity::class);
    }

    public function it_has_customer()
    {
        $customer = (new Customer())
            ->setName('John Doe')
            ->setEmail('john.d@acme-corp.co.za');

        $this->setCustomer($customer);

        $this->getCustomer()
            ->shouldHaveType(Customer::class);
    }

    public function it_has_ref_number()
    {
        $refNumber = '20240402-2010-8768';

        $this->setRefNumber($refNumber);

        $this->getRefNumber()
            ->shouldBe($refNumber);
    }

    public function it_has_description()
    {
        $description = 'Bought Carling Black Label on credit @ R30 (excl. VAT) for 1.';

        $this->setDescription($description);

        $this->getDescription()
            ->shouldBe($description);
    }

    public function it_has_total()
    {
        $this->setTotal(30.0);

        $this->getTotal()
            ->shouldBe(30.0);
    }
}
