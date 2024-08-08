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

namespace CoolStuff\Shared\Workflow\Tests\Domain;

use Exception;
use CoolStuff\Shared\Workflow\Tests\DomainTester;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use CoolStuff\Component\Testing\Concern\InteractsWithDatabase;
use CoolStuff\Component\Testing\Concern\InteractsWithFixtures;

/**
 * Class TestCase
 *
 * @package CoolStuff\Shared\Workflow\Tests\Domain
 */
abstract class TestCase extends DomainTester
{
    use InteractsWithDatabase;
    use InteractsWithFixtures;

    protected static ContainerBuilder $container;

    /**
     * Sets up the currently used Container interface.
     */
    public function setContainer(): void
    {
        $container = include_once __DIR__.'/../../../../../bootstrap/app.php';

        /*
         * Delay Container assignment by type-checking against
         * expected implementer of the ContainerInterface
        */
        if ($container instanceof ContainerBuilder) {
            static::$container = $container;
        }
    }

    /**
     * Load a single fixture for this test.
     *
     * @param bool $executeFixtures
     *
     * @throws Exception
     */
    protected function loadFixture(string $fixtureClass, $executeFixtures = true)
    {
        if (! class_exists($fixtureClass)) {
            throw new Exception("Fixture class {$fixtureClass} does not exists.");
        }

        $container = self::$container;

        /** @var FixtureInterface $fixture */
        $fixture = $container->get($fixtureClass);

        $this->addFixture($container, $fixture);

        if ($executeFixtures) {
            $this->executeFixtures($container);
        }
    }

    /**
     * Load fixtures for this test.
     *
     * @throws Exception
     */
    protected function addFixtures(array $fixtureClasses)
    {
        $container = self::$container;

        foreach ($fixtureClasses as $fixtureClass) {
            $this->loadFixture($fixtureClass, false);
        }

        $this->executeFixtures($container);
    }

    /**
     * Entity classes from which tables should be created for this test.
     */
    abstract protected function entityClasses(): array;
}