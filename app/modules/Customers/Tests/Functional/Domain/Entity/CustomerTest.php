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

namespace CoolStuff\Customers\Tests\Functional\Domain\Entity;

use CoolStuff\Customers\Domain\Entity\Customer;
use CoolStuff\Customers\Tests\Functional\TestCase;
use CoolStuff\Customers\Domain\Fixture\CustomerFixture;

/**
 * Class CustomerTest.
 *
 * @package CoolStuff\Customers\Tests\Functional\Domain\Entity
 */
final class CustomerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    public function testItCanPersistACustomer()
    {
        $john = (new Customer())
            ->setName('John Doe')
            ->setEmail('john.d@example.com');

        $this->entityManager->persist($john);

        $this->entityManager->flush();

        self::assertSame(1, $john->getId());
    }

    public function testItCanPersistCustomers()
    {
        $john = (new Customer())
            ->setName('Berle Doe')
            ->setEmail('berle.d@example.com');

        $mary = (new Customer())
            ->setName('Mary Doe')
            ->setEmail('mary.d@example.com');

        $this->entityManager->persist($john);
        $this->entityManager->persist($mary);

        $this->entityManager->flush();

        $customers = $this->entityManager
            ->getRepository(Customer::class)
            ->findAll();

        self::assertCount(2, $customers);
    }

    public function testItCanReadCustomers()
    {
        $this->loadFixture(CustomerFixture::class);

        $customers = $this->entityManager
            ->getRepository(Customer::class)
            ->findAll();

        self::assertCount(CustomerFixture::QUOTA, $customers);
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
