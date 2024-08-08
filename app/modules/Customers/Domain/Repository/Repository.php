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

namespace CoolStuff\Customers\Domain\Repository;

/**
 * Interface Repository.
 *
 * @package CoolStuff\Customers\Domain\Repository
 */
interface Repository
{
    public function getById($id);

    public function getAll();

    public function create($entity);

    public function begin();

    public function commit();
}
