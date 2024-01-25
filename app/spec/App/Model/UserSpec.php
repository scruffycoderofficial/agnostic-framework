<?php
/*
 * This file is part of the D6 Assessment Project.
 *
 * (c) Luyanda Siko <sikoluyanda@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace spec\D6\Invoice\App\Model;

use PhpSpec\ObjectBehavior;
use D6\Invoice\App\Model\User;

class UserSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith(
            1,
            'John',
            'Doe',
            'john.d@example.com',
            '0838765345',
            '13 Kowie Close, Delft, Cape Town 8000',
            'testing'
        );
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(User::class);
    }

    public function it_knows_about_its_properties()
    {
        $this->getuserId()->shouldBe(1);
        $this->getFirstName()->shouldBe('John');
        $this->getlastName()->shouldBe('Doe');
        $this->getEmail()->shouldBe('john.d@example.com');
        $this->getMobile()->shouldBe('0838765345');
        $this->getAddress()->shouldBe('13 Kowie Close, Delft, Cape Town 8000');
        $this->getPassword()->shouldBe('testing');
    }
}
