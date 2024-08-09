<?php
/*
 * This file is part of the CoolStuff Enterprise Project.
 *
 * (c) Luyanda Siko <sikoluyanda@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CoolStuff\App\Fixture;

use Exception;
use CoolStuff\Component\Entity\Type\Money;
use Doctrine\Persistence\ObjectManager;
use CoolStuff\App\Common\Entity\Product;
use Doctrine\Common\DataFixtures\FixtureInterface;
use CoolStuff\App\Common\Entity\ProductType\UnitMeasure;

/**
 * Class ProductFixture.
 *
 * @package CoolStuff\App\Fixture
 */
class ProductFixture implements FixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        try {
            $blackLabel = new Product();

            $blackLabel
                ->setName('Black Label')
                ->setDescription('A beer that not only champions drink but also the general public enjoys too. In the black eyes, truth is labelled.')
                ->setUnitMeasure(new UnitMeasure('Case', '750', 'ml'))
                ->setUnit(1)
                ->setUnitPrice(new Money(240, 'ZAR'));

            $manager->persist($blackLabel);

            $castleLager = new Product();

            $castleLager
                ->setName('Castle Lager')
                ->setDescription('Only a select few can withstand this great bear. It goes down well it its most chilled state under breezing sunny weather.')
                ->setUnitMeasure(new UnitMeasure('Case', '750', 'ml'))
                ->setUnit(1)
                ->setUnitPrice(new Money(185, 'ZAR'));

            $manager->persist($castleLager);

            $manager->flush();
        } catch (Exception $exc) {
        }
    }
}
