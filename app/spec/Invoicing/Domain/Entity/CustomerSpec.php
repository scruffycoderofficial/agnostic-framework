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
use CoolStuff\Invoicing\Domain\Entity\Customer;

/**
 * Class CustomerSpec.
 *
 * @package spec\CoolStuff\Invoicing\Domain\Entity
 */
class CustomerSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(Customer::class);
    }

    public function it_is_an_entity()
    {
        $this->shouldBeAnInstanceOf(Entity::class);
    }

    public function it_has_name()
    {
        $this->setName('John Doe');

        $this->getName()
            ->shouldBe('John Doe');
    }

    public function it_has_email()
    {
        $this->setEmail('john.d@acme-corp.co.za');

        $this->getEmail()
            ->shouldBe('john.d@acme-corp.co.za');
    }
}
