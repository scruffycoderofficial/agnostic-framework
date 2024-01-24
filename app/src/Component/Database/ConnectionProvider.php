<?php
/*
 * This file is part of the D6 Assessment Project.
 *
 * (c) Luyanda Siko <sikoluyanda@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace D6\Invoice\Component\Database;

use PDO;

/**
 * Class ConnectionProvider
 */
class ConnectionProvider
{
    private $pdo;

    /**
     * @param $dsn
     * @param $username
     * @param $password
     * @return PDO
     */
    public function createConnector($dsn, $username, $password): PDO
    {
        $this->pdo = new PDO($dsn, $username, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_PERSISTENT => true,
        ]);

        return $this->pdo;
    }

    public function getPdo(): PDO
    {
        return $this->pdo;
    }
}
