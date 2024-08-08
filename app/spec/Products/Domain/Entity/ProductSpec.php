<?php
/*
 * This file is part of the CoolStuff Enterprise Project.
 *
 * (c) Luyanda Siko <sikoluyanda@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace spec\CoolStuff\Products\Domain\Entity;

use PhpSpec\ObjectBehavior;
use CoolStuff\Products\Domain\Entity\Product;

class ProductSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(Product::class);
    }
}
