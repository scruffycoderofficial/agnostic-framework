<?php
/*
 * This file is part of the D6 Assessment Project.
 *
 * (c) Luyanda Siko <sikoluyanda@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace D6\Invoice\Component\Repository;

use Doctrine\DBAL\Connection;

/**
 * Class DbalRepository
 */
abstract class DbalRepository implements Repository
{
    protected $queryBuilder;

    public function __construct(protected Connection $connection)
    {
        $this->queryBuilder = $connection->createQueryBuilder();
    }
}
