<?php
/*
 * This file is part of the D6 Assessment Project.
 *
 * (c) Luyanda Siko <sikoluyanda@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace spec\D6\Invoice\App\Console\Command;

use PhpSpec\ObjectBehavior;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use D6\Invoice\App\Console\Command\ListUsersCommand;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class ListUsersCommandSpec
 */
class ListUsersCommandSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(ListUsersCommand::class);
    }

    public function it_is_a_console_command()
    {
        $this->shouldBeAnInstanceOf(Command::class);
    }
}
