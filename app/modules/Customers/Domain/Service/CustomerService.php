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

namespace CoolStuff\Customers\Domain\Service;

use PHPMentors\DomainKata\Entity\EntityInterface;

/**
 * Interface CustomerService.
 *
 * @package CoolStuff\Customers\Domain\Service
 */
interface CustomerService
{
    /**
     * @return EntityInterface[]
     */
    public function getAll(): mixed;

    /**
     * Adds a new Customer entity to the storage.
     */
    public function addCustomer(EntityInterface $entity): mixed;
}
