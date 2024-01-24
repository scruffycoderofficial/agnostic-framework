<?php
/*
 * This file is part of the D6 Assessment Project.
 *
 * (c) Luyanda Siko <sikoluyanda@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace spec\D6\Invoice\Component\Console\Command;

use PhpSpec\ObjectBehavior;
use D6\Invoice\Component\Console\Command\ListUsersCommand;

class ListUsersCommandSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(ListUsersCommand::class);
    }
}
