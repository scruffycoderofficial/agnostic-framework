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

namespace CoolStuff\Suppliers\Tests\Functional\Domain\Entity;

use CoolStuff\Shared\Entity\Location\Address;
use CoolStuff\Shared\Entity\Location\Country;
use CoolStuff\Suppliers\Domain\Entity\Supplier;
use CoolStuff\Suppliers\Tests\Functional\TestCase;

/**
 * Class SupplierTest.
 *
 * @package CoolStuff\Suppliers\Tests\Functional\Domain\Entity
 */
final class SupplierTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    public function testItCanPersistASupplierWithoutAnAddress()
    {
        $supplier = (new Supplier())
            ->setName('Zonke Distribution')
            ->setLicenseNumber('WP-0987654321')
            ->setTelephone('0897654321');

        $this->entityManager->persist($supplier);
        $this->entityManager->flush();

        self::assertFalse(! $supplier->hasAddresses());
        self::assertSame(1, $supplier->getId());
    }

    public function testItCanPersistASupplierWithAnAddress()
    {
        $country = (new Country())
            ->setCode('za')
            ->setName('South Africa');

        $address = (new Address())
            ->setStreet('9 Kowie Close')
            ->setSuburb('Delft, Leiden')
            ->setCity('Cape Town')
            ->setPostalCode('8000')
            ->setCountry($country);

        $supplier = (new Supplier())
            ->setName('Al Hidayah, Cash and Carry')
            ->setLicenseNumber('WP-0000000000')
            ->setTelephone('0747749191')
            ->setAddress($address);

        $this->entityManager->persist($supplier);
        $this->entityManager->flush();

        self::assertCount(1, $supplier->getAddresses());
        self::assertSame($address->getCountry()->getName(), $supplier->getAddresses()->first()->getCountry()->getName());
    }

    public function testItCanPersistASupplierWithMoreThanOneAddress()
    {
        $country = (new Country())
            ->setCode('za')
            ->setName('South Africa');

        $address1 = (new Address())
            ->setStreet('9 Kowie Close')
            ->setSuburb('Delft, Leiden')
            ->setCity('Cape Town')
            ->setPostalCode('8000')
            ->setCountry($country);

        $address2 = (new Address())
            ->setStreet('1508 N.U 10')
            ->setSuburb('Mdantsane')
            ->setCity('East London')
            ->setPostalCode('5219')
            ->setCountry($country);

        $supplier = (new Supplier())
            ->setName('Al Hidayah, Cash and Carry')
            ->setLicenseNumber('WP-0000000000')
            ->setTelephone('0747749191')
            ->setAddress($address1)
            ->setAddress($address2);

        $this->entityManager->persist($supplier);
        $this->entityManager->flush();

        self::assertCount(2, $supplier->getAddresses());

        self::assertSame($address1->getCountry()->getName(), $supplier->getAddresses()->first()->getCountry()->getName());
        self::assertSame($address2->getCountry()->getName(), $supplier->getAddresses()->last()->getCountry()->getName());

        self::assertNotSame($supplier->getAddresses()->first()->getPostalCode(), $supplier->getAddresses()->last()->getPostalCode());
    }

    protected function entityClasses(): array
    {
        return [
            Country::class,
            Address::class,
            Supplier::class,
        ];
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }
}
