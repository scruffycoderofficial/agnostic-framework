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

namespace CoolStuff\Customers\Persistence\Doctrine\Repository;

use CoolStuff\Customers\Domain\Entity\Customer;
use CoolStuff\Customers\Domain\Repository\CustomerRepository as CustomerRepositoryInterface;

/**
 * Class CustomerRepository.
 *
 * @package CoolStuff\Customers\Persistence\Doctrine\Repository
 */
final class CustomerRepository extends AbstractDoctrineRepository implements CustomerRepositoryInterface
{
    protected string $entityClass = Customer::class;

    public function getById($id): mixed
    {
        return $this->getBy(['id' => $id]);
    }
}
