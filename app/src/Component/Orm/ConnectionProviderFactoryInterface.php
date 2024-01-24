<?php
/*
 * This file is part of the D6 Assessment Project.
 *
 * (c) Luyanda Siko <sikoluyanda@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace D6\Invoice\Component\Orm;

use PDO;

/**
 * Interface ConnectionProviderFactoryInterface
 */
interface ConnectionProviderFactoryInterface
{
    /**
     * @return PDO
     */
    public function createConnectionProvider(): PDO;
}
