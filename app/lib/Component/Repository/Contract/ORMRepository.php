<?php
/*
 * This file is part of the CoolStuff Enterprise Project.
 *
 * (c) Luyanda Siko <sikoluyanda@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CoolStuff\Component\Repository\Contract;

use PHPMentors\DomainKata\Repository\RepositoryInterface;

/**
 * Interface ORMRepository.
 *
 * @package CoolStuff\Component\Repository\Contract
 */
interface ORMRepository extends \IteratorAggregate, \Countable, RepositoryInterface
{
    public function getIterator(): \Iterator;

    public function slice(int $start, int $size = 20): self;

    public function count(): int;
}
