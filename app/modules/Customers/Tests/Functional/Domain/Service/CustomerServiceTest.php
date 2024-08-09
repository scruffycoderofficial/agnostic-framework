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

namespace CoolStuff\Customers\Tests\Functional\Domain\Service;

use CoolStuff\Customers\Domain\Entity\Customer;
use CoolStuff\Customers\Tests\Functional\TestCase;
use CoolStuff\Customers\Domain\Service\DefaultCustomerService;

/**
 * Class CustomerServiceTest.
 *
 * @package CoolStuff\Customers\Tests\Functional\Domain\Service
 */
class CustomerServiceTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    public function testItCanPersistAndReadCustomer()
    {
        $customerService = self::$container->get(DefaultCustomerService::class);

        $customer = (new Customer())
            ->setName('John Doe')
            ->setEmail('john.d@example.com');

        $customerService->addCustomer($customer);

        self::assertCount(1, $customerService->getAll());
    }

    protected function entityClasses(): array
    {
        return [Customer::class];
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }
}
