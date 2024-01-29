<?php
/*
 * This file is part of the D6 Assessment Project.
 *
 * (c) Luyanda Siko <sikoluyanda@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace spec\D6\Invoice\Component\Twig\Extension;

use PhpSpec\ObjectBehavior;
use D6\Invoice\Component\Twig\Extension\AppExtension;

/**
 * Class AppExtensionSpec
 */
class AppExtensionSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(AppExtension::class);
    }

    public function it_returns_an_array_lists_of_filters()
    {
        $this->getFilters()->shouldBeArray();
    }

    public function it_has_a_name()
    {
        $this->getName()->shouldBeString();
    }

    public function it_returns_value_on_passed_datetime()
    {
        $this->tssFilter(date_sub(new \DateTime(), new \DateInterval('P2DT2H2M')))->shouldBe('Some time back');
    }
}
