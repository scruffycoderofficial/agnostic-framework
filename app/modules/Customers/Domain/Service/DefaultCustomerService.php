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

use InvalidArgumentException;
use CoolStuff\Customers\Domain\Entity\Customer;
use PHPMentors\DomainKata\Entity\EntityInterface;
use CoolStuff\Customers\Domain\Repository\CustomerRepository;

/**
 * Class DefaultCustomerService.
 *
 * @package CoolStuff\Customers\Domain\Service
 */
final class DefaultCustomerService implements CustomerService
{
    /**
     * CustomerService constructor.
     */
    public function __construct(private CustomerRepository $customerRepository)
    {
    }

    public function getAll(): mixed
    {
        return $this->customerRepository->getAll();
    }

    public function addCustomer(EntityInterface $customer): mixed
    {
        if ($customer instanceof Customer){
            throw new InvalidArgumentException();
        }

        $this->customerRepository->create($customer);
    }
}
