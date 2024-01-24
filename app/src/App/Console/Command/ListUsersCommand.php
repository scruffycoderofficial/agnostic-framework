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

use Doctrine\DBAL\Connection;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class ListUsersCommand
 */
class ListUsersCommand extends Command
{
    private const HEADERS = ['ID', 'First Name', 'Last Name', 'Email', 'Mobile', 'Address', 'Created', 'Updated'];

    public function __construct(private Connection $connection)
    {
        parent::__construct('app:users:list');
    }

    protected function configure()
    {
        $this->setDescription('Lists all users registered within the system."');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $table = new Table($output);

        $table
            ->setHeaders(self::HEADERS)
            ->setRows($this->getResult());

        $table->render();

        return Command::SUCCESS;
    }

    private function getResult()
    {
        $statement = $this->connection->prepare('SELECT * FROM users');

        $resultSet = $statement->executeQuery();

        $results = [];

        array_map(function ($entry) use (&$results) {
            array_push($results, [
                $entry['id'],
                $entry['first_name'],
                $entry['last_name'],
                $entry['email'],
                $entry['mobile'],
                $entry['address'],
                $entry['created_at'],
                $entry['updated_at'],
            ]);
        }, $resultSet->fetchAllAssociative());

        return $results;
    }
}
