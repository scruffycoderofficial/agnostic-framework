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

namespace CoolStuff\Customers\Domain\Fixture;

use Faker\Factory;
use Doctrine\Persistence\ObjectManager;
use CoolStuff\Customers\Domain\Entity\Customer;
use Doctrine\Common\DataFixtures\FixtureInterface;

/**
 * Class CustomerFixture.
 *
 * @package CoolStuff\Customers\Domain\Fixture
 */
final class CustomerFixture implements FixtureInterface
{
    /**
     * Number of faked Customers.
     */
    public const QUOTA = 10;

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('en_ZA');

        $customers = [];
        for ($j = 0; $j < self::QUOTA; $j++) {
            $customers[] = (new Customer())
                ->setName($faker->name)
                ->setEmail($faker->email);
        }

        array_map(function (Customer $customer) use ($manager) {
            $manager->persist($customer);
        }, $customers);

        $manager->flush();
    }
}
