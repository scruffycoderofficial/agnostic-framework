<?php
/*
 * This file is part of the CoolStuff Enterprise Project.
 *
 * (c) Luyanda Siko <sikoluyanda@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace spec\CoolStuff\Suppliers\Domain\Entity;

use PhpSpec\ObjectBehavior;
use CoolStuff\Component\Entity\Entity;
use CoolStuff\Shared\Entity\Location\Address;
use CoolStuff\Suppliers\Domain\Entity\Supplier;

class SupplierSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(Supplier::class);
    }

    public function it_is_an_entity()
    {
        $this->shouldBeAnInstanceOf(Entity::class);
    }

    public function it_has_name()
    {
        $this->setName('Maj');

        $this->getName()->shouldBe('Maj');
    }

    public function it_has_license_number()
    {
        $this->setLicenseNumber('WPC-5467098723');

        $this->getLicenseNumber()->shouldBe('WPC-5467098723');
    }

    public function it_has_a_telephone()
    {
        $this->setTelephone('06787654320');

        $this->getTelephone()->shouldBe('06787654320');
    }

    public function it_has_an_address()
    {
        $this->setAddress(new Address());
    }
}
