<?php
/*
 * This file is part of the D6 Assessment Project.
 *
 * (c) Luyanda Siko <sikoluyanda@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace spec\D6\Invoice\Component\Console;

use PhpSpec\ObjectBehavior;
use D6\Invoice\Component\Console\Application;

/**
 * Class ApplicationSpec
 */
class ApplicationSpec extends ObjectBehavior
{
    /**
     * Constructor arguments
     */
    public function let()
    {
        $this->beConstructedWith([]);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(Application::class);
    }
}
