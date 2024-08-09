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

namespace CoolStuff\Shared\Workflow\Tests;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\SchemaTool;
use PHPUnit\Framework\TestCase as BaseTestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Class DomainTester
 *
 * @package CoolStuff\Shared\Workflow\Tests
 */
abstract class DomainTester extends BaseTestCase
{
    protected static ContainerBuilder $container;

    protected function setUp(): void
    {
        parent::setUp();

        $this->setContainer();
    }

    protected function getSchemaTool(): ?SchemaTool
    {
        if (! static::$container->has(SchemaTool::class)) {
            if (! static::$container->has(EntityManager::class)) {
                throw new \Exception('This TestCase does not support running of migration on per TestCase basis.');
            }

            return new SchemaTool(static::$container->get(EntityManager::class));
        } else {
            return static::$container->get(SchemaTool::class);
        }
    }

    protected function createTables(SchemaTool $schemaTool, array $classes)
    {
        $schemaTool->createSchema($classes);
    }

    protected function dropTables(SchemaTool $schemaTool, array $classes)
    {
        $schemaTool->dropSchema($classes);
    }

    abstract public function setContainer(): void;
}
