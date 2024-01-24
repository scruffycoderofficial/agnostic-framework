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
use Exception;

/**
 * Class ConnectionProviderFactory
 */
class ConnectionProviderFactory
{
    /**
     * @param $dsn
     * @param $username
     * @param $password
     * @return PDO
     * @throws Exception
     */
    public function createConnectionProvider($dsn, $username, $password): PDO
    {
        $provider = new ConnectionProvider();

        try {
            return $provider->createConnector($dsn, $username, $password);
        } catch (Exception $exc) {
            throw new Exception($exc->getMessage());
        }
    }
}
