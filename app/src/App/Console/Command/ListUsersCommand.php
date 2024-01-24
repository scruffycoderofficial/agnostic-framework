<?php
/*
 * This file is part of the D6 Assessment Project.
 *
 * (c) Luyanda Siko <sikoluyanda@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace D6\Invoice\App\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class ListUsersCommand
 */
class ListUsersCommand extends Command
{
    protected function configure()
    {
        $this->setName('app:salute')
            ->setDescription('Prints "Hello, [the given user name]!"')
            ->setHelp('Demonstration of custom commands created by Symfony Console component.')
            ->addArgument('username', InputArgument::REQUIRED, 'Pass your first name.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln(sprintf('Hello, %s!', $input->getArgument('username')));

        return Command::SUCCESS;
    }
}
