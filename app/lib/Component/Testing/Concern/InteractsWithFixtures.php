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

namespace CoolStuff\Component\Testing\Concern;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Symfony\Bridge\Doctrine\DataFixtures\ContainerAwareLoader;

/**
 * Trait InteractsWithFixtures.
 *
 * @package CoolStuff\Component\Testing\Concern
 */
trait InteractsWithFixtures
{
    /**
     * @var ContainerAwareLoader
     */
    protected $fixtureLoader;

    protected ORMExecutor $fixtureExecutor;

    public function addFixture($container, FixtureInterface $fixture): void
    {
        $this->getFixtureLoader($container)->addFixture($fixture);
    }

    public function executeFixtures($container, $append = true): void
    {
        $this->getFixtureExecutor()->execute($this->getFixtureLoader($container)->getFixtures(), $append);
    }

    private function getFixtureLoader($container): ContainerAwareLoader
    {
        return new ContainerAwareLoader($container);
    }

    private function getFixtureExecutor(): ORMExecutor
    {
        return new ORMExecutor($this->entityManager, new ORMPurger($this->entityManager));
    }
}
