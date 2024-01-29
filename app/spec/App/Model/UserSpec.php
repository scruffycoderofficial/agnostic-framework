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

/**
 * Class UserSpec
 *
 * @package spec\D6\Invoice\App\Model
 */
class UserSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith(
            1,
            'Luyanda',
            'Siko',
            'sikoluyanda@gmail.com',
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
        $this->getId()->shouldBe(1);
        $this->getFirstName()->shouldBe('Luyanda');
        $this->getlastName()->shouldBe('Siko');
        $this->getEmail()->shouldBe('sikoluyanda@gmail.com');
        $this->getMobile()->shouldBe('0838765345');
        $this->getAddress()->shouldBe('13 Kowie Close, Delft, Cape Town 8000');
        $this->getPassword()->shouldBe('testing');
    }
}
