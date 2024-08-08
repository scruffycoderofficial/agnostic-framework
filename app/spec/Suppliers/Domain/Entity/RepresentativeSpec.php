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
use CoolStuff\Suppliers\Domain\Entity\Representative;

class RepresentativeSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(Representative::class);
    }

    public function it_is_an_entity()
    {
        $this->shouldBeAnInstanceOf(Entity::class);
    }

    public function it_has_first_name()
    {
        $this->setFirstName('Jane');

        $this->getFirstName()->shouldBe('Jane');
    }

    public function it_has_last_name()
    {
        $this->setLastName('Doe');

        $this->getLastName()->shouldBe('Doe');
    }

    public function it_has_mobile_number()
    {
        $this->setMobileNumber('08390010111');

        $this->getMobileNumber()->shouldBeString();
    }

    public function it_has_email_address()
    {
        $this->setEmailAddress('jane.doe@example.com');

        $this->getEmailAddress()->shouldBeEqualTo('jane.doe@example.com');
    }
}
