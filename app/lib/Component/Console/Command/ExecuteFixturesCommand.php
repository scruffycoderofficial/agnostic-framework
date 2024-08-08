<?php
/*
 * This file is part of the CoolStuff Enterprise Project.
 *
 * (c) Luyanda Siko <sikoluyanda@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

declare(strict_types=1);

namespace CoolStuff\Component\Console\Command;

use Doctrine\ORM\EntityManager;
use Doctrine\Common\DataFixtures\Loader;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;

/**
 * Class ExecuteFixturesCommand.
 *
 * @package CoolStuff\Component\Console\Command
 */
final class ExecuteFixturesCommand extends Command
{
    private static string $defaultName = 'fixtures:load';

    public function __construct(
        private EntityManager $entityManager,
        private Loader $loader,
        private ORMPurger $purger,
        private ORMExecutor $executor,
        private string $path
    ) {
        parent::__construct(self::$defaultName);
    }

    protected function configure()
    {
        $this->setDescription('Loads one or multiple fixtures.')
            ->addOption(
                'class',
                null,
                InputOption::VALUE_OPTIONAL,
                'Execute a specific fixture.',
                false
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->purger->setEntityManager($this->entityManager);
        $this->executor->setPurger($this->purger);

        if (false === $input->getOption('class')) {
            $this->loader->loadFromDirectory($this->path);
        } else {
            $this->loader->loadFromFile($this->path.DIRECTORY_SEPARATOR.$input->getOption('class').'.php');
        }

        $fixtures = $this->loader->getFixtures();

        $this->executor->execute($fixtures, true);

        foreach ($fixtures as $fixture) {
            $output->writeln(sprintf('<info>Executing %s </info>', $fixture::class));
        }

        $output->writeln('<info>Fixtures have been loaded.</info>');
        $output->writeln("\n");
        $output->write("<info>                .''
      ._.-.___.' (`\
     //(        ( `'
    '/ )\ ).__. )
    ' <' `\ ._/'\
       `   \     \
</info>");

        return Command::SUCCESS;
    }
}
