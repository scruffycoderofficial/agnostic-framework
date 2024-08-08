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

use ReflectionClass;
use DateTimeImmutable;
use Doctrine\Common\DataFixtures\Loader;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use function filemtime;

/**
 * Class ListFixturesCommand.
 *
 * @package CoolStuff\Component\Console\Command
 */
final class ListFixturesCommand extends Command
{
    private static string $defaultName = 'fixtures:list';

    public function __construct(private Loader $loader, private string $path)
    {
        parent::__construct(self::$defaultName);
    }

    protected function configure(): void
    {
        $this->setDescription('List all available fixtures.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->loader->loadFromDirectory($this->path);

        $rows = [];

        $commandName = ExecuteFixturesCommand::getDefaultName();

        foreach ($this->loader->getFixtures() as $fixture) {
            $reflectionClass = null;

            try {
                $reflectionClass = new ReflectionClass($fixture);
            } catch (\ReflectionException $e) {
                $output->write($e->getMessage());
            } finally {
                $lastUpdatedAt = DateTimeImmutable::createFromFormat(
                    'U',
                    (string) filemtime($reflectionClass->getFileName())
                );

                $rows[] = [
                    'namespace'       => $reflectionClass->getName(),
                    'command'         => $commandName.' --class='.$reflectionClass->getShortName(),
                    'last_updated_at' => $lastUpdatedAt->format('Y-m-d H:i:s'),
                ];
            }
        }

        $table = new Table($output);

        $table
            ->setHeaders(['Namespace', 'Run fixture command', 'Last updated at'])
            ->setRows($rows)
            ->render();

        return Command::SUCCESS;
    }
}
