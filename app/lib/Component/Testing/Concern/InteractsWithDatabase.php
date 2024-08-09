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

use Doctrine\ORM\EntityManager;

/**
 * Trait InteractsWithDatabase.
 *
 * @package CoolStuff\Component\Testing\Concern
 */
trait InteractsWithDatabase
{
    private array $entityClasses = [];

    protected EntityManager $entityManager;

    /**
     * Sets up our test cases.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->entityManager = static::$container->get(EntityManager::class);

        $this->createTables($this->getSchemaTool(), $this->classMetadataCollection());
    }

    protected function classMetadataCollection(): array
    {
        $classes = [];

        foreach ($this->entityClasses() as $entityClass) {
            if (class_exists($entityClass)) {
                array_push($classes, $this->entityManager->getClassMetadata($entityClass));
            }
        }

        return $classes;
    }

    /**
     * Tears down our test cases.
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        $this->dropTables($this->getSchemaTool(), $this->classMetadataCollection());
    }
}
